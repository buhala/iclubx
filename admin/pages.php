<?php
include '../functions.php';
admin_top('Страници');

$return = '';
if (!$_GET || isset($_GET['page'])) {
    $title = 'Списък със страници';
    $tbl_name = "pages";
    $adjacents = 2;

    $query = "SELECT COUNT(*) as num FROM $tbl_name ";
    $total_pages = assoc(mysql_query($query)) or die(mysql_error());
    $total_pages = $total_pages['num'];

    $targetpage = "pages.php?page="; //Link
    $limit = 15; //Elements per page
    $page = (int)$_GET['page'];
    $minus = mb_substr($page, 0, 1, "utf-8");
    if ($minus == '-') {
        redirect('/');
    }
    if ($page)
        $start = ($page - 1) * $limit;
    else
        $start = 0;

    $sql = "SELECT * FROM $tbl_name ORDER BY id ASC LIMIT $start, $limit";
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
    $return = '<table>
        <thead><tr><th>#</th><th>Заглавие</th><th>Автор</th><th>Дата</th><th>Действие</th></tr></thead>
        <tbody>';
    while ($page = assoc($query)) {
        $author_query = query('SELECT `username` FROM `users` WHERE `id`=' . $page['author']);
        $author = assoc($author_query);
        $return .= '<tr class="'.$page['id'].'"><td>'.$page['id'].'</td><td>' . $page['title'] . '</td><td>' . $author['username'] . '</td><td>' . date('d M Y H:i:s',$page['added']) . '</td><td><a href="pages.php?edit=' . $page['id'] . '" title="Редактирай"><img src="resources/images/pencil.png" alt="Редактирай" /></a></span><a href="#" id="'.$page['id'].'" class="delete" title="Изтрий"><img src="resources/images/cross.png" alt="Изтрий" /></a></td></tr>';
    }
    $return .= '</tbody></table>';
    $return .= $pagination;
    ?>
    <script type="text/javascript">
        $(function () {
            $("a.delete").click(function () {
               var sure = confirm("Сигурни ли сте, че искате да изтриете страницата?");
               var id = $(this).attr('id');
               if(sure==true) {
                   $.ajax({
                       url: 'delete.php',
                       type: 'POST',
                       data: 'delete=page&id=' + id,
                       success: function (result) {
                           if(result == "1") {
                               $('tr.' + id).fadeOut(500);
                           } else if(result == "2") {
                               alert("Страницата е защитена и не може да си изтрие!");
                           } else  if(result == "3") {
                               alert("Страницата не съществува!");
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
} elseif(isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $query = query('SELECT * FROM `pages` WHERE `id`='.$id);
    if(mysql_num_rows($query)!=1) {
        $title = 'Страницата не съществува!';
        $return = '<div class="notification error png_bg">
        <a href="#" name="msg" class="close"><img src="resources/images/cross_grey_small.png" title="Затвори" alt="Затвори" /></a>
        <div>Страницата не съществува!</div>
    </div> 
    <a href="pages.php" class="button">Списък със страници</a>';
    } else {
        $page = assoc($query);
        $title = 'Редактиране на "'.$page['title'].'"';
        if(isset($_POST['edit'])) {
            $ptitle = escape($_POST['title']);
            $author = (int)$_POST['author'];
            $content = addslashes($_POST['content']);
            
            if(strlen(trim($ptitle))<2) {
                $error[] = 'Въвели сте твърде кратко заглавие!';
            }
            if(strlen(trim($content))<2) {
                $error[] = 'Въвели сте твърде кратко съдържание!';
            }
            if(!isset($error)) {
                query('UPDATE `pages` SET `title` = "'.$ptitle.'",`author`='.$author.',`content`="'.$content.'" WHERE `id`='.$id);
                if(mysql_error()) {
                    $error[] = 'MySQL Error: '.mysql_error();
                } else {
                    $ok = 'Страницата е обновена успешно!';
                }
            }
        } else {            
            $ptitle = $page['title'];
            $author = $page['user_id'];
            $content = $page['content'];
        }
        $return .= '<form method="POST">
                <p>
                    <label>Заглавие</label>
                    <input type="text" name="title" class="text-input medium-input" value="'.stripslashes($ptitle).'">
                </p>
                <p>
                    <label>Автор</label>
                    <select name="author" class="text-input medium-input">';
        $users_query = query('SELECT `id`,`username` FROM `users`');
        while($users = assoc($users_query)) {
            $u .= '<option value="'.$users['id'].'">'.$users['username'].'</option>
                        ';
        }
        $return .= str_replace('<option value="'.$author.'">','<option value="'.$author.'" selected>',$u);
        $return .= '</select>
                </p>
                <p>
                    <span>Съдържание</span>
                    <textarea class="text-input textarea wysiwyg" id="textarea" name="content" cols="79" rows="15">'.stripslashes($content).'</textarea>
                </p>
                <p>
                    <input type="submit" name="edit" value="Редактирай" class="button"> <button onclick="location.href=\'pages.php\'" class="button">Спъсък със страници</button>
                </p>
            </form>';
    }
} elseif(isset($_GET['m'])) {
    if($_GET['m']=='add') {
        $title = 'Добавяне на страница';
        
        if(isset($_POST['add'])) {
            dump_var($_POST);
            $ptitle = escape($_POST['title']);
            $author = (int) $_POST['author'];
            $content = addslashes($_POST['content']);
            
            if(strlen(trim($ptitle))<2) {
                $error[] = 'Въвели сте твърде кратко заглавие!';
            }
            if(strlen(trim($content))<2) {
                $error[] = 'Въвели сте твърде кратко съдържание!';
            }
            if(count($error)==0) {
                query('INSERT INTO `pages` (`user_id`,`title`,`content`,`lang`,`added`) 
                    VALUES('.$author.',"'.$ptitle.'","'.$content.'","bg",'.time().')');
                if(mysql_error()) {
                    $error[] = 'MySQL Error: '.mysql_error();
                } else {
                    $ok = 'Страницата е добавена успешно!';
                    $ptitle = '';
                    $content = '';
                }
            }
        }
        $return .= '<form method="POST">
                <p>
                    <label>Заглавие</label>
                    <input type="text" name="title" class="text-input medium-input" value="'.stripslashes($ptitle).'">
                </p>
                <p>
                    <label>Автор</label>
                    <select name="author" class="text-input medium-input">';
        $users_query = query('SELECT `id`,`username` FROM `users`');
        while($users = assoc($users_query)) {
            $u .= '<option value="'.$users['id'].'">'.$users['username'].'</option>
                        ';
        }
        $return .= str_replace('<option value="'.$author.'">','<option value="'.$author.'" selected>',$u);
        $return .= '</select>
                </p>
                <p>
                    <span>Съдържание</span>
                    <textarea class="text-input textarea wysiwyg" id="textarea" name="content" cols="79" rows="15">'.stripslashes($content).'</textarea>
                </p>
                <p>
                    <input type="submit" name="add" value="Добави" class="button"> <button onclick="location.href=\'pages.php\'" class="button">Спъсък със страници</button>
                </p>
            </form>';
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
        <?php
        if(isset($error)) {
            foreach($error as $value) {
                ?> <div class="notification error png_bg"><a href="#" name="msg" class="close"><img src="resources/images/cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div><?php echo $value; ?></div></div> <?php
            }
        } elseif(isset($ok)) {
            ?><div class="notification success png_bg"><a href="#" name="msg" class="close"><img src="resources/images/cross_grey_small.png" title="Затвори" alt="Затвори" /></a><div><?php echo $ok; ?></div></div> <?php
        }
        if (isset($return)) {
            echo $return;
        }
        ?>
<?php admin_footer(); ?>