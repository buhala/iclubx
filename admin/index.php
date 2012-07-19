<?php

include '../functions.php';
if(isset($_SESSION['logged'])) {
    redirect('home.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Администраторки панел</title>
        <!--                       CSS                       -->
        <!-- Reset Stylesheet -->
        <link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
        <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
        <link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
        <!-- Colour Schemes
        Default colour scheme is green. Uncomment prefered stylesheet to use it.
        <link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />  
        -->
        <!-- Internet Explorer Fixes Stylesheet -->
        <!--[if lte IE 7]>
                <link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
        <![endif]-->
        <!--                       Javascripts                       -->
        <!-- jQuery -->
        <script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
        <!-- jQuery Configuration -->
        <script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
        <!-- Facebox jQuery Plugin -->
        <script type="text/javascript" src="resources/scripts/facebox.js"></script>
        <!-- jQuery WYSIWYG Plugin -->
        <script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
        <!-- Internet Explorer .png-fix -->
        <!--[if IE 6]>
                <script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
                <script type="text/javascript">DD_belatedPNG.fix('.png_bg, img, li');</script>
        <![endif]-->
    </head>
    <body id="login">
        <div id="login-wrapper" class="png_bg">
            <div id="login-top">
                <a href="../" alt="Към сайта" title="Към сайта"><img id="logo" src="../images/logo_1.png" alt="sStats" /></a>
            </div>
            <div id="login-content">
                <?php if(@$_GET['msg']==1) {?>
                <div class="notification">
                    <div class="error">Wrong data!</div>
                </div>
                <?php } ?>
                <form action="login.php" method="POST">
                    <p>
                        <label>Username</label>
                        <input class="text-input" name="username" type="text" />
                    </p>
                    <div class="clear"></div>
                    <p>
                        <label>Password</label>
                        <input class="text-input" name="password" type="password" />
                    </p>
                    <div class="clear"></div>
                    <p>
                        <input class="button" type="submit" name="login" value="Вход" />
                    </p>
                </form>
            </div> <!-- End #login-content -->
        </div> <!-- End #login-wrapper -->
    </body>
</html>
