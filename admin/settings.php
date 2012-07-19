<?php

ob_start();
include '../functions.php';
admin_top('Настройки');
if (isset($_POST['siteinfo'])) {
    $sitename = escape($_POST['sitename']);
    $sitedesc = escape($_POST['sitedesc']);
    $sitekeywords = escape($_POST['sitekeywords']);
    $siteemail = escape($_POST['siteemail']);
    $siteurl = escape($_POST['siteurl']);
    $sitepath = escape($_POST['sitepath']);
    
    mysql_query("UPDATE `settings` SET `name`='$sitename',`description`='$sitedesc',`keywords`='$sitekeywords',`email`='$siteemail',`url`='$siteurl',`path`='$sitepath'") or die(mysql_error());
    redirect('settings.php?msg=1');
}
?>
<div class="content-box">
    <div class="content-box-header">
        <h3>Настройки</h3>
        <div class="clear"></div>
    </div>
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="#msg" method="post">
                <fieldset>
                    <p>
                        <label>Заглавие на сайта</label>
                        <input class="text-input large-input" type="text" name="sitename" value="<?php echo $site['name']; ?>" />
                    </p>
                    <p>
                        <label>Описание на сайта</label>
                        <input class="text-input large-input" type="text" name="sitedesc" value="<?php echo $site['description']; ?>" />
                    </p>
                    <p>
                        <label>Ключови думи</label>
                        <input class="text-input large-input" type="text" name="sitekeywords" value="<?php echo $site['keywords']; ?>" />
                    </p>
                    <p>
                        <label>Е-поща</label>
                        <input class="text-input large-input" type="text" name="siteemail" value="<?php echo $site['email']; ?>" />
                    </p>
                    <p>
                        <label>Домейн</label>
                        <input class="text-input large-input" type="text" name="siteurl" value="<?php echo $site['url']; ?>" />
                    </p>
                    <p>
                        <label>Път до сайта</label>
                        <input class="text-input large-input" type="text" name="sitepath" value="<?php echo $site['path']; ?>" />
                    </p>
                    <p>
                        <input name="siteinfo" class="button" type="submit" />
                    </p>
                </fieldset>
                <div class="clear"></div>
            </form>   
<?php admin_footer(); ?>