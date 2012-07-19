<?php

include '../functions.php';

if (isset($_POST['login'])) {
    $user = escape($_POST['username']);
    $pass = escape($_POST['password']);

    $query = query("SELECT * FROM `users` WHERE `username`='$user' AND `password`='".password($pass)."'") or die(mysql_error());
    if (mysql_num_rows($query) != 1) {
        redirect('index.php?msg=1');
        //Грешно потребителско име или парола
    } else {
        $row = mysql_fetch_assoc($query);
        query('UPDATE `users` SET `ip`="'.$_SERVER['REMOTE_ADDR'].'", `last_login`='.time().' WHERE `id`='.$row['id']) or die(mysql_error());
        $_SESSION['userinfo'] = $row;
        $_SESSION['logged'] = TRUE;
        redirect('index.php');
    }
}
?>
