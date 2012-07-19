<?php

if (mb_strstr($_SERVER["PHP_SELF"], "template/admin_footer.php", "UTF-8")) {
    die('<h1>Access denied!</h1>');
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 1) {
        $type = 'success';
        $text = 'Обновяването е успешно!';
    } elseif ($_GET['msg'] == 2) {
        $type = 'success';
        $text = 'Добавянето е успешно!';
    } elseif ($_GET['msg'] == 3) {
        $type = 'success';
        $text = 'Съобщението е изпратено успешно!';
    }
    ?>
    <div class="notification <?php echo $type ?> png_bg">
        <a href="#" name="msg" class="close"><img src="resources/images/cross_grey_small.png" title="Затвори" alt="Затвори" /></a>
        <div><?php echo $text; ?></div>
    </div>    
    <?php
}
?>    </div>
</div>

</div> 
<div id="footer">
    <small>
        &copy; Създадено от <a href="http://ygeorgiev.eu" title="Код от Ясен Георгиев">Ясен Георгиев</a> | Powered by <a href="http://sgroup.net/">sGroup</a> | <a href="#">Нагоре</a>
    </small>
</div>
</div>
</body>
</html>
