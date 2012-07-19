<?php

include 'functions.php';
top('Home');
$query = query('SELECT `title`,`content` FROM `pages` WHERE `id` = 1') or die(mysql_error());
$page = assoc($query);
echo '<h1>'.$page['title'].'</h1>'.$page['content'];
footer();
?>