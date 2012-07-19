<?php
ob_start();
include '../functions.php';

admin_top('Статии');
$return = '';
if ($_GET['m'] == 'list' || $_GET['page'] || !$_GET) { 
    $title = 'Списък със статии';
    
    $tbl_name = "posts";
    $adjacents = 10;

    $query = "SELECT COUNT(*) as num FROM $tbl_name ";
    $total_pages = assoc(mysql_query($query)) or die(mysql_error());
    $total_pages = $total_pages[num];

    $targetpage = "posts.php?page="; //Link
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
    if(mysql_num_rows($query)==0) {
        $table = '<tr><td colspan="7" style="text-align: center;">Няма добавени статии!</td></tr>';
    }
    while ($post = assoc($query)) {
        $author_query = mysql_query('SELECT `id`,`username` FROM `users` WHERE `id`='.$post['author']) or die(mysql_error());
        $author = assoc($author_query);

        $table .= '<tr class="'.$post['id'].'"><td>' . $post['id'] . '</td><td>' . $post['title'] . '</td><td><a href="users.php?edit='.$author['id'].'" title="Редактирай потребителя">' . $author['username'] . '</a></td><td>'.date('d M Y в H:i',$post['added']).'</td><td><a href="posts.php?edit=' . $post['id'] . '" title="Редактирай"><img src="resources/images/pencil.png" alt="Редактирай" /></a><a href="#" id="'.$post['id'].'" class="delete" title="Изтрий"><img src="resources/images/cross.png" alt="Изтрий" /></a></td></tr>';
    }
    $list = TRUE;    
    ?>
<script type="text/javascript">
    $(function () {
        $("a.delete").click(function () {
           var sure = confirm("Сигурни ли сте, че искате да изтриете статията?");
           var id = $(this).attr('id');
           if(sure==true) {
               $.ajax({
                   url: 'delete.php',
                   type: 'POST',
                   data: 'delete=post&id=' + id,
                   success: function (result) {
                       if(result == "1") {
                           $('tr.' + id).fadeOut(500);
                       } else if(result == "2") {
                           alert("Статията не съществува!");
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
    $query = mysql_query('SELECT * FROM `posts` WHERE `id`=' . $id);
    $row = assoc($query);
    if(mysql_num_rows($query)==1) {
        $edit = TRUE;
        $title = 'Редактиране на статията "'.$row['title'].'"';
        if(isset($_POST['edit'])) {
            $ptitle = escape($_POST['title']);
            $content = escape($_POST['content'],'nohtml');
            $author = (int)$_POST['author'];

            if(strlen($ptitle)<2) {
                $error[] = 'Заглавието трябва да е поне два символа!';
            }
            if(strlen($content)<2) {
                $error[] = 'Съдържанието трябва да е поне два символа!';
            }
            if(count($error)==0) {
                $q = mysql_query('SELECT `id` FROM `posts` WHERE `title`="'.$ptitle.'" AND `id`!='.$row['id']);
                if(mysql_num_rows($q)==0) {
                    mysql_query('UPDATE `posts` SET `title`="'.$ptitle.'",`content`="'.$content.'",`author`='.$author.' WHERE `id`='.$row['id']);
                    if(mysql_error()) {
                        $error[] = 'MySQL Error: '.mysql_error();
                    } else {
                        redirect('posts.php?edit='.$id.'&msg=1');
                    }
                } else {
                    $error[] = 'Заглавието е заето!';
                }
            }
            if($error) {
                foreach($error as $value) {
                    $return .= '<div class="notification error png_bg"><a href="#" name="msg" class="close"><img src="resources/images//cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div>'.$value.'</div></div>';
                }
            }
        } else {
            $ptitle = $row['title'];
            $content = $row['content'];
            $tags = $row['tags'];
            $author = $row['author'];
            $cat = $row['cat'];
        }
    } else {
        redirect('posts.php?m=list&noe');
    }
} elseif($_GET['m']=='add') {
    $title = 'Добавяне на статия';
    if(isset($_POST['add'])) {
        $ptitle = escape($_POST['title']);
        $content = escape($_POST['content'],'nohtml');
        $author = (int)$_POST['author'];

        if(strlen($ptitle)<2) {
            $error[] = 'Заглавието трябва да е поне два символа!';
        }
        if(strlen($content)<2) {
            $error[] = 'Съдържанието трябва да е поне два символа!';
        }
        if(count($error)==0) {
            $q = mysql_query('SELECT `id` FROM `posts` WHERE `title`="'.$ptitle.'"');
            if(mysql_num_rows($q)==0) {
                mysql_query('INSERT INTO `posts` VALUES(NULL,"'.$ptitle.'","'.$content.'",'.$author.','.time().')');
                if(mysql_error()) {
                    $error[] = 'MySQL Error: '.mysql_error();
                } else {
                    redirect('posts.php?m=add&msg=2');
                }
            } else {
                $error[] = 'Заглавието е заето!';
            }
        }
        if($error) {
            foreach($error as $value) {
                $return .= '<div class="notification error png_bg"><a href="#" name="msg" class="close"><img src="resources/images//cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div>'.$value.'</div></div>';
            }
        }
    } else {
        $author = $_SESSION['userinfo']['id'];
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
            <?php if(isset($_GET['noe'])) { echo '<div class="notification error png_bg"><a href="#" name="msg" class="close"><img src="resources/images/cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div>Статията не съществува!</div></div>'; }?>
<?php if ($list) { ?>
                <table>
                    <thead>
                        <tr><th>#</th><th>Име</th><th>Автор</th><th>Добавена</th><th>Действие</th></tr>
                    </thead>
                    <tbody>
    <?php
    echo $table;
    ?>
                    </tbody>
                </table>
            <?php  echo $pagination;  } elseif ($edit) { ?>
                <form method="POST" action="posts.php?edit=<?php echo $id?>">
                    <p>
                        <label>Заглавие</label>
                        <input type="text" name="title" class="text-input medium-input" value="<?php echo $ptitle ?>">
                    </p>
                    <p>
                        <label>Съдържание</label>
                        <textarea class="text-input textarea wysiwyg" id="textarea" name="content" cols="79" rows="15"><?php echo $content; ?></textarea>
                    </p>
                    <p>
                        <label>Автор:</label>
                        <select name="author" class="text-input medium-input">
                            <?php 
                            $users = mysql_query('SELECT `id`,`username` FROM `users`');
                            while($user = assoc($users)) {
                                $u .= '<option value="'.$user['id'].'">'.$user['username'].'</option>';
                            }
                            $u = str_replace('<option value="'.$author.'">','<option value="'.$author.'" selected>',$u);
                            echo $u;
                            ?>
                        </select>
                    </p>
                    <p>
                        <input type="submit" name="edit" value="Редактирай" class="button" /> <input type="button" name="back" class="button" onclick="location.href='posts.php?m=list'" value="Назад">
                    </p>
                </form>
<?php if($return) { echo $return; } }  elseif($_GET['m']=='add') { ?>
                <form method="POST" action="posts.php?m=add">
                    <p>
                        <label>Заглавие</label>
                        <input type="text" name="title" class="text-input medium-input" value="<?php echo $ptitle ?>">
                    </p>
                    <p>
                        <label>Съдържание</label>
                        <textarea class="text-input textarea wysiwyg" id="textarea" name="content" cols="79" rows="15"><?php echo $content; ?></textarea>
                    </p>
                    <p>
                        <label>Автор:</label>
                        <select name="author" class="text-input medium-input">
                            <?php 
                            $users = mysql_query('SELECT `id`,`username` FROM `users`');
                            while($user = assoc($users)) {
                                $u .= '<option value="'.$user['id'].'">'.$user['username'].'</option>';
                            }
                            $u = str_replace('<option value="'.$author.'">','<option value="'.$author.'" selected>',$u);
                            echo $u;
                            ?>
                        </select>
                    </p>
                    <p>
                        <input type="submit" name="add" value="Добави" class="button" /> <input type="button" name="back" class="button" onclick="location.href='posts.php?m=list'" value="Назад">
                    </p>
                </form>
<?php if($return) { echo $return; } } ?>
<?php admin_footer(); ?>