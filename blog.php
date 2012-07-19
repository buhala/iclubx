<?php

include 'functions.php';
top('Blog');
echo '<h1>Blog</h1>';

$query = query('SELECT `title`,`content` FROM `posts` ORDER BY `id` DESC');
while($post = assoc($query)) {
    $i++;
    echo '<h2>'.$post['title'].'</h2>'.$post['content'];
    if($i!=  mysql_num_rows($query)) {
        echo '<hr />';
    }
}

footer();
?>
