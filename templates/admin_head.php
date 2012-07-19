<?php

if (mb_strstr($_SERVER["PHP_SELF"], "template/admin_head.php", "UTF-8")) {
    die('<h1>Access denied!</h1>');
}

include '../config.inc.php';
if (!$_SESSION['logged']) {
    redirect('index.php');
}
$user = $_SESSION['userinfo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?> - Администраторски панел</title>
        <link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
        <link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
        <!--[if lte IE 7]>
                <link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
        <![endif]-->
        <script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
        <script type="text/javascript" src="resources/scripts/facebox.js"></script>
        <script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="resources/scripts/jquery.datePicker.js"></script>
        <script type="text/javascript" src="resources/scripts/jquery.date.js"></script>
        <!--[if IE]><script type="text/javascript" src="resources/scripts/jquery.bgiframe.js"></script><![endif]-->
        <!-- Internet Explorer .png-fix -->
        <!--[if IE 6]>
                <script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
                <script type="text/javascript">
                    DD_belatedPNG.fix('.png_bg, img, li');
                </script>
        <![endif]-->

    </head>
    <body>
        <div id="body-wrapper">
            <div id="sidebar">
                <div id="sidebar-wrapper">
                    <a href="../"><img id="logo" src="../images/logo_1.png" width="200" alt="Към сайта" /></a>
                    <div id="profile-links">
                        Здравей, <?php echo $user['username']; ?>!<br />
                        <a href="../">Преглед на сайта</a> | <a href="logout.php" title="Изход">Изход</a>
                    </div>        
                    <ul id="main-nav">
                        <li><a href="./" class="nav-top-item <?php if (mb_strstr($_SERVER["PHP_SELF"], "home.php", "UTF-8")) { echo 'current'; } ?>">Табло</a></li>
                        <li><a href="#" class="nav-top-item <?php if (mb_strstr($_SERVER["PHP_SELF"], "pages.php", "UTF-8")) { echo 'current'; } ?>">Страници</a>
                            <ul>
                                <li><a href="pages.php?m=add" class="<?php if (mb_strstr($_SERVER["PHP_SELF"], "pages.php", "UTF-8") && $_GET['m'] == 'add') {  echo 'current'; } ?>">Добави</a>
                                </li>
                                <li><a href="pages.php" class="<?php if ((mb_strstr($_SERVER["PHP_SELF"], "pages.php", "UTF-8") || $_GET['page']) && !$_GET) { echo 'current'; } ?>">Списък</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="nav-top-item <?php if (mb_strstr($_SERVER["PHP_SELF"], "posts.php", "UTF-8")) { echo 'current'; } ?>">Публикации</a>
                            <ul>
                                <li><a href="posts.php?m=add" class="<?php  if (mb_strstr($_SERVER["PHP_SELF"], "posts.php", "UTF-8") && $_GET['m'] == 'add') { echo 'current'; } ?>">Добави</a></li>
                                <li><a href="posts.php" class="<?php  if ((mb_strstr($_SERVER["PHP_SELF"], "posts.php", "UTF-8") || $_GET['page']) && !$_GET) { echo 'current'; } ?>">Списък</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="nav-top-item <?php if (mb_strstr($_SERVER["PHP_SELF"], "users.php", "UTF-8")) {  echo 'current'; } ?>">Потребители</a>
                            <ul>
                                <li><a href="users.php?m=add" class="<?php if (mb_strstr($_SERVER["PHP_SELF"], "users.php", "UTF-8") && $_GET['m'] == 'add') { echo 'current'; } ?>">Добави</a></li>
                                <li><a href="users.php?m=list" class="<?php if ((mb_strstr($_SERVER["PHP_SELF"], "users.php", "UTF-8") || $_GET['page']) && $_GET['m'] == 'list') { echo 'current'; } ?>">Списък</a></li>
                            </ul>
                        </li>
                        <li><a href="settings.php" class="nav-top-item <?php if (mb_strstr($_SERVER["PHP_SELF"], "settings.php", "UTF-8")) { echo 'current'; } ?>">Настройки</a></li>
                    </ul>

                </div>
            </div>
            <div id="main-content">
                <h2>Административен панел на sStats</h2>
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <li>
                        <a href="pages.php?m=add" class="shortcut-button"><span>
                                <img src="resources/images/paper.png" alt="icon" /><br>
                                    Нова страница
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="images/.php?m=add" class="shortcut-button"><span>
                                <img src="resources/images/picture.png" alt="icon" /><br>
                                    Нова снимка
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="users.php?m=add" class="shortcut-button"><span>
                                <img src="resources/images/user.jpg" alt="icon" /><br>
                                    Нов потребител
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="shortcut-button"><span>
                                <img src="resources/images/settings.png" alt="icon" /><br>
                                    Настройки
                            </span>
                        </a>
                    </li>
                </ul>
                <div class="clear"></div>

