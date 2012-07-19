<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

date_default_timezone_set('Europe/Sofia');
if (mb_strstr($_SERVER["PHP_SELF"], "config.php", "UTF-8")) {
    die('<h1>Access denied!</h1>');
}

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'iclubx';

mysql_connect($dbhost, $dbuser, $dbpass) or die('MySQL Connection');
mysql_select_db($dbname) or die('Database');
mysql_query('SET NAMES utf8');

$query = mysql_query('SELECT * FROM settings');
$row = mysql_fetch_assoc($query);
if(is_array($row)) {
    foreach($row as $key=>$value) {
        $site[$key]=trim(stripslashes($value));
    }
} else {
    die('Settings error!');
}
?>
