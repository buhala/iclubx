<?php

include 'functions.php';
top('Staff');
echo '<h1>Staff</h1>';
mysql_select_db($site['game_db']);
$query = query('SELECT * FROM `users` WHERE `ismoderator`=1 ORDER BY `points` ASC');
while($user = assoc($query)) {
	$i++;
	if(mysql_num_rows($query)!=$i) {
		$float = 'style="float: left;"';
	}
	echo '<table '.$float.'><tr><td><h2>'.$user['username'].'</h2></td></tr><tr><td><iframe frameborder="0" src="http://cfmedia.sexyi.am/play/content/liveview.swf?setColor='.$user['colour'].'&setFeet='.$user['curfeet'].'&setHand='.$user['curhands'].'&setHead='.$user['curhead'].'&setNeck='.$user['curneck'].'&setFace='.$user['curface'].'&setBody='.$user['curbody'].'&setFlag='.$user['curflag'].'&setBackground='.$user['curphoto'].'&mood='.$user['mood'].'" width="250" height="250"></iframe></td></tr></table>';
}
footer();
?>