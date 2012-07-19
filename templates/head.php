<?php
if (mb_strstr($_SERVER["PHP_SELF"], "template/head.php", "UTF-8")) {
    die('<h1>Access denied!</h1>');
}
include 'config.inc.php'; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title; ?> | <?php echo $site['name']?></title>
        <meta name="description" content="<?php echo $site['description']; ?>">
        <meta name="keywords" content="<?php echo $site['keywords']; ?>/">
        <meta name="robots" content="index,follow" />
        <link type="text/css" rel="stylesheet" href="<?php echo $site['url'];?>/css/style.css" />
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div class="logo"></div>
                <div class="menu">
                    <a href="<?php echo $site['url']; ?>/home">Home</a> · <a href="<?php echo $site['url']; ?>/about">About</a> · <a href="<?php echo $site['url']; ?>/blog">Blog</a> · <a href="<?php echo $site['url']; ?>/play">Play</a> · <a href="<?php echo $site['url']; ?>/register">Register</a> · <a href="<?php echo $site['url']; ?>/staff">Staff</a> · <a href="<?php echo $site['url']; ?>/donate">Donate</a> · <a href="<?php echo $site['url']; ?>/support">Support</a>
                </div>
            </div>
            <div id="content">