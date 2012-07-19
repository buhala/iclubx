<?php
ob_start();
include '../functions.php';
admin_top('Потребители');

if ($_GET['m'] == 'list' || $_GET['page'] || !$_GET) { 
    
    $tbl_name = "users";
    $adjacents = 2;
    
    $title = 'Списък с потребители';
    $query = "SELECT COUNT(*) as num FROM $tbl_name ";
    $total_pages = assoc(mysql_query($query)) or die(mysql_error());
    $total_pages = $total_pages[num];

    $targetpage = "users.php?page="; //Link
    $limit = 10; //Elements per page
    $page = (int) $_GET['page'];
    $minus = mb_substr($page, 0, 1, "utf-8");
    if ($minus == '-') {
        redirect('/');
    }
    if ($page)
        $start = ($page - 1) * $limit;
    else
        $start = 0;
    $sql = "SELECT * FROM $tbl_name ORDER BY `id` ASC LIMIT $start, $limit";
    $query = mysql_query($sql) or die(mysql_error());

    if ($page == 0)
        $page = 1;
    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total_pages / $limit);
    $lpm1 = $lastpage - 1;

    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= '<div class="pagination">';
        if ($page > 1)
            $pagination.= "";
        else
            $pagination.= "";

        if ($lastpage < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination.= "<a class='number current'>$counter</a>&nbsp;";
                else
                    $pagination.= "<a href=\"$targetpage$counter\" class='number'>$counter</a>&nbsp;";
            }
        }
        elseif ($lastpage > 5 + ($adjacents * 2)) {

            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination.= "<a class='number current'>$counter</a>&nbsp;";
                    else
                        $pagination.= "<a href=\"$targetpage$counter\" class='number'>$counter</a>&nbsp;";
                }
                $pagination.= "<a class='number' href='#страница'>...</a>";
                $pagination.= "<a href=\"$targetpage$lpm1\" class='number'>$lpm1</a>&nbsp;";
                $pagination.= "<a href=\"$targetpage$lastpage\" class='number'>$lastpage</a>&nbsp;";
            }

            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination.= "<a href=\"" . $targetpage . "1\" class='number'>1</a>&nbsp;";
                $pagination.= "<a href=\"" . $targetpage . "2\" class='number'>2</a>&nbsp;";
                $pagination.= "<a class='number' href='#страница'>...</a>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<a class='number current'>$counter</a>&nbsp;";
                    else
                        $pagination.= "<a href=\"$targetpage$counter\" class='number'>$counter</a>&nbsp;";
                }
                $pagination.= "<a class='number' href='#страница'>...</a>";
                $pagination.= "<a href=\"$targetpage$lpm1\" class='number'>$lpm1</a>&nbsp;";
                $pagination.= "<a href=\"$targetpage$lastpage\" class='number'>$lastpage</a>&nbsp;";
            }
            else {
                $pagination.= "<a href=\"" . $targetpage . "1\" class='number'>1</a>&nbsp;";
                $pagination.= "<a href=\"" . $targetpage . "2\" class='number'>2</a>&nbsp;";
                $pagination.= "<a class='number' href='#страница'>...</a>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<a class='number current'>$counter</a>&nbsp;";
                    else
                        $pagination.= "<a href=\"$targetpage$counter\" class='number'>$counter</a>&nbsp;";
                }
            }
        }

        if ($page < $counter - 1)
            $pagination.= "";
        else
            $pagination.= "";
        $pagination.= "</div>\n";
    }
    $table = '<table>
                    <thead>
                        <tr><th>#</th><th>Потребителско име</th><th>IP</th><th>Последен вход</th><th>Регистрация</th><th>Действие</th></tr>
                    </thead>
                    <tbody>';
    if(mysql_num_rows($query)==0) {
        $table .= '<tr><td colspan="8" style="text-align: center;">Няма добавени потребители!</td></tr>';
    }
    while ($user = assoc($query)) {
        if($user['last_login']==0) {
            $login = 'Не е влизал';
        } else {
            $login = date('d M Y в H:i',$user['last_login']);
        }
        $table .= '<tr id="'.$user['id'].'"><td>' . $user['id'] . '</td><td><span class="username">' . $user['username'] . '</span></td><td>'.$user['ip'].'</td><td>'.$login.'</td><td>'.date('d M Y в H:i',$user['added']).'</td><td><a href="users.php?edit=' . $user['id'] . '" title="Редактирай"><img src="resources/images/pencil.png" alt="Редактирай" /></a> <a href="#" id="'.$user['id'].'" class="delete" title="Изтрий"><img src="resources/images/cross.png" alt="Изтрий" /></a></td></tr>';
    }
    $table .= ' </tbody></table>'.$pagination;
    $list = TRUE;    
    ?>
    <script type="text/javascript">
        $(function () {
            $("a.delete").click(function () {
               var sure = confirm("Сигурни ли сте, че искате да изтриете потребителя?");
               var id = $(this).attr('id');
               if(sure==true) {
                   $.ajax({
                       url: 'delete.php',
                       type: 'POST',
                       data: 'delete=user&id=' + id,
                       success: function (result) {
                           if(result == "1") {
                               $('tr.' + id).fadeOut(500);
                           } else if(result == "2") {
                               alert("Потребителят не съществува!");
                           } else  {
                               alert(result);
                           }
                       }
                   })
               }
               return false;
            });
        });  
    </script>
<?php
} elseif (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $query = mysql_query('SELECT * FROM `users` WHERE `id`=' . $id);
    $row = assoc($query);
    if(mysql_num_rows($query)==1) {
        $edit = TRUE;
        $title = 'Редактиране на '.$row['username'];
        if(isset($_POST['edit'])) {
            $pass = escape($_POST['pass']);
            $rpass = escape($_POST['rpass']);

            if(strlen($pass)!=0) {
                if(strlen($pass) < 6) {
                    $error[] = 'Паролата трябва да е поне 6 символа!';
                }
                if($pass!=$rpass) {
                    $error[] = 'Двете пароли не съвпадат!';
                }
            } else {
                $error[] = 'Новата паролата е твърде кратка!';
            }
            if(count($error)==0) {
                mysql_query('UPDATE `users` SET `password`="'.password($pass).'"  WHERE `id`='.$id);
                if(mysql_error()) {
                    $error[] = 'MySQL Error: '.mysql_error();
                } else {
                    redirect('users.php?edit='.$id.'&msg=1');
                }
            }
            if($error) {
                foreach($error as $value) {
                    $return .= '<div class="notification error png_bg"><a href="#" name="msg" class="close"><img src="resources/images//cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div>'.$value.'</div></div>';
                }
            }
        } else {
            $username = $row['username'];
            $email = $row['email'];
            $type = $row['type'];
            $status = $row['status'];
        }
    } else {
        redirect('users.php?m=list&noe');
    }
} elseif($_GET['m']=='add') {
    $title = 'Добавяне на потребител';
   if(isset($_POST['edit'])) {
        $username = escape($_POST['username']);
        $pass = escape($_POST['pass']);
        $rpass = escape($_POST['rpass']);

        if (strlen($username) < 3 || strlen($username) > 20 || eregi("[^a-zA-Z0-9_.-]", $username)) {
            $error[] = 'Потребителското име не може да бъде прието!';
        }
        if(strlen($pass)!=0) {
            if(strlen($pass) < 6) {
                $error[] = 'Паролата трябва да е поне 6 символа!';
            }
            if($pass!=$rpass) {
                $error[] = 'Двете пароли не съвпадат!';
            }
        } else {
            $error[] = 'Трябва да въведете парола!';
        }
        if(count($error)==0) {
            $usern = mysql_query('SELECT `username` FROM `users` WHERE `username`="'.$username.'"') or die(mysql_error());
            if(mysql_num_rows($usern) > 0) {
                $error[] = "Потребителското име е заето!";
            } else {
                mysql_query("INSERT INTO `users` (`username`, `password`, `ip`,`added`) VALUES ('$username', '" . password($pass) . "', 'Не е влизал', " . time() . ")") or die(mysql_error());
                if(mysql_error()) {
                    $error[]='MySQL Error: '.mysql_error();
                } else {
                    redirect('users.php?m=add&msg=2');
                }
            }
        }
        if($error) {
            foreach($error as $value) {
                $return .= '<div class="notification error png_bg"><a href="#" name="msg" class="close"><img src="resources/images/cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div>'.$value.'</div></div>';
            }
        }
    }
}
?>
<div class="content-box">
    <div class="content-box-header">
        <h3><?php echo $title ?></h3>
        <div class="clear"></div>
    </div>
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <?php if(isset($_GET['noe'])) {
                    echo '<div class="notification error png_bg"><a href="#" name="msg" class="close"><img src="resources/images//cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div>Категорията не съществува!</div></div>'; 
                }
                if ($list) { 
                    echo $table;
                } elseif ($edit) { ?>
                <form method="POST" action="users.php?edit=<?php echo $id?>">
                    <p>
                        <label>Потребителско име</label>
                        <input type="text" name="username" class="text-input medium-input" disabled="disabled" value="<?php echo $row['username'] ?>">
                    </p>
                    <p>
                        <label>Нова парола</label>
                        <input type="password" name="pass" class="text-input medium-input" value="">
                    </p>
                    <p>
                        <label>Повтори паролата</label>
                        <input type="password" name="rpass" class="text-input medium-input" value="">
                    </p>
                    <p>
                        <input type="submit" name="edit" value="Редактирай" class="button" /> <input type="button" name="back" class="button" onclick="location.href='category.php'" value="Назад">
                    </p>
                </form>
<?php if($return) { echo $return; } }  elseif($_GET['m']=='add') { ?>
                <form method="POST" action="users.php?m=add">
                    <p>
                        <label>Потребителско име</label>
                        <input type="text" name="username" class="text-input medium-input" value="<?php echo $username; ?>">
                    </p>
                    <p>
                        <label>Парола</label>
                        <input type="password" name="pass" class="text-input medium-input" value="">
                    </p>
                    <p>
                        <label>Повтори паролата</label>
                        <input type="password" name="rpass" class="text-input medium-input" value="">
                    </p>
                    <p>
                        <input type="submit" name="edit" value="Редактирай" class="button" /> <input type="button" name="back" class="button" onclick="location.href='category.php'" value="Назад">
                    </p>
                </form>
<?php if($return) { echo $return; } } elseif($_GET['m']=='sendmsg') { ?>
            <form method="POST" action="users.php?m=sendmsg">
                <p>
                    <label>Изпрати до</label>
                    <select name="receiver" class="text-input medium-input">
                        <option value="0">До всички потребители</option>
                        <?php 
                        $users_query = mysql_query('SELECT `user_id`,`username` FROM `users`');
                        while($user_list = assoc($users_query)) {
                            $users .= '<option value="'.$user_list['user_id'].'">'.$user_list['username'].'</option>';
                        }
                        echo str_replace('<option value="'.$user.'">','<option value="'.$user.'" selected>',$users);
                        ?>
                    </select>
                </p>
                <p>
                    <label>Заглавие</label>
                    <input type="text" name="title" value="<?php echo $msgtitle?>" class="text-input medium-input" />
                </p>
                <p>
                    <label>Съобщение</label>
                    <textarea name="message" class="medium-input" style="height: 150px;"><?php echo $message ?></textarea>
                </p>
                <p>
                    <input type="submit" name="send" value="Изпрати" class="button" />
                </p>
            </form>
            <?php echo $return; ?>
<?php } admin_footer(); ?>