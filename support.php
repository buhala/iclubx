<?php

include 'functions.php';
top('Support');
?>
<h1>Support</h1>
<div style="float: right;">
    <img src="images/contacts.gif" alt="Contact us" />
</div>
<div>
    <?php
    if(isset($_POST['send'])) {
        $username = trim($_POST['nickname']);
        $email = trim($_POST['email']);
        $title = trim($_POST['title']);
        $msg = trim($_POST['msg']);
        
        if(strlen($username)<4) {
            $error[] = 'Too short nickname';
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $error[] = 'Invalid email';
        }
        if(strlen($msg) < 4) {
            $error[] = 'Too short message';
        }
        if(!$error) {
            $headers='MIME-Version: 1.0'."\r\n";
            $headers.='Content-type: text/html; charset=UTF-8'."\r\n";
            $headers.='From: '.$username.' <'.$email.'>'."\r\n";
            $message = '<p style="font-style: italic;">'.$msg.'</p>';
            mail($site['email'], $title, stripslashes($message), $headers);
            echo '<p style="color: green">Message sent!</p>';
        }
    }
    if($error) {
        echo '<b>The following erros were detected while sending your form:</b>';
        foreach($error as $value) {
            echo '<p style="color: red">'.$value.'</p>';
        }
    }
    ?>
    <form method="POST">
        <p>
            <span>Nickname</span><br />
            <input type="text" name="nickname" value="<?php echo $username; ?>"><br />
            <span>Email</span><br />
            <input type="text" name="email" value="<?php echo $email; ?>"><br />
            <span>Title</span><br />
            <input type="text" name="title" value="<?php echo $title; ?>"><br />
            <span>Message</span><br />
            <textarea name="msg" rows="5" cols="40"><?php echo $msg; ?></textarea><br />
        </p>
        <p>
            <input type="submit" name="send" value="Send" style="border: 1px solid;"/>
        </p>
    </form>
</div>

<?php footer(); ?>