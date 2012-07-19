<?php

include 'functions.php';
$query = query('SELECT `title`,`content` FROM `pages` WHERE `id` = 2') or die(mysql_error());
$page = assoc($query);
top($page['title']);
echo '<h1>'.$page['title'].'</h1>'.$page['content'];
footer();
?>
