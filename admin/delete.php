<?php

include '../functions.php';

if($_SESSION['logged']) {
    if(isset($_POST['delete']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        //Страница
        if($_POST['delete']=='page') {
            $query = mysql_query('SELECT `id` FROM `pages` WHERE `id`='.$id) or die(mysql_error());
            if(mysql_num_rows($query)==1) {
                $page = assoc($query);
                if($page['id']!=1) {
                    mysql_query('DELETE FROM `pages` WHERE `id`='.$id) or die(mysql_error());
                    echo '1';
                } else {
                    echo '2';
                }
            } else {
                echo '3';
            }
        //Статия
        } elseif($_POST['delete']=='post') {
            $query = mysql_query('SELECT `id` FROM `posts` WHERE `id`='.$id) or die(mysql_error());
            if(mysql_num_rows($query)==1) {
                mysql_query('DELETE FROM `posts` WHERE `id`='.$id) or die(mysql_error());
                echo '1';
            } else {
                echo '2';
            }
        //Потребител
        } elseif($_POST['delete']=='user') {
            $query = mysql_query('SELECT `id` FROM `users` WHERE `id`='.$id) or die(mysql_error());
            if(mysql_num_rows($query)==1) {
                mysql_query('DELETE FROM `users` WHERE `id`='.$id) or die(mysql_error());
                echo '1';
            } else {
                echo '2';
            }
        }
        
    }
} else {
    redirect('../');
}
?>
