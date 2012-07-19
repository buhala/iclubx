<?php

include 'functions.php';
include 'recaptchalib.php';
$privatekey = "6LeDxtISAAAAACdDt3dbMxWhVMa5iCRfjp3NR_Bz ";
top('Register');
echo '<h1>Register</h1>';


if ($_POST['submit'] == 'Register') {
    $login = escape(trim(strip_str_lines($_POST['login'])));
    $pass = trim($_POST['pass']);
    $pass2 = trim($_POST['pass2']);
    $email = escape(trim($_POST['email']));
    $color = (int) $_POST['color'];
	$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

    if (strlen($login) < 4) {
        $error_array[] = 'Your username is too short!';
    }
    if (strlen($pass) < 6) {
        $error_array[] = 'Your password is too short!';
    }
    if ($pass != $pass2) {
        $error_array[] = 'Password mismatch!';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_array[] = 'Invalid email!';
    }
    if (!$resp->is_valid) {
        $error_array[] = 'Your code has been entered incorrect!';
    }
    if ($color == 0) {
        $color = rand(1, 13);
    }
    if (count($error_array) == 0) {
		mysql_select_db($site['game_db']);
        $rs = mysql_query('SELECT COUNT(*) as cnt FROM users WHERE username="' . $login . '" OR email="' . $email . '"');
        $row = mysql_fetch_assoc($rs);

        if ($row['cnt'] == 0) {
            query("INSERT INTO users (`id`, `username`, `nickname`, `email`, `password`, `active`, `ubdate`, `items`, `curhead`, `curface`, `curneck`, `curbody`, `curhands`, `curfeet`, `curphoto`, `curflag`, `colour`, `buddies`, `ignore`, `lkey`, `coins`, `ismoderator`, `rank`)
                    VALUES (NULL, '" . $login . "', '" . $login . "', '" . $email . "', '" . md5($pass) . "', '1', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '" . $color . "', '', '', '', '1000', '0', '1')");
            if (mysql_error()) {
                $error_array[] = mysql_error();
            } else {
                $ok = 'Complete! You can now play ' . $site['name'] . '!';
            }
        } else {
            $error_array[] = 'Your username and/or email are already in use.';
        }
    }
}

if ($error_array) {
    echo '<p style="color: red; font-weight: bold">Errors:</p>';
    foreach ($error_array as $value) {
        echo '<p style="color: red;">' . $value . '</p>';
    }
}
if ($ok) {
    echo '<p class="ok">' . $ok . '</p>';
}
?> 
<script type="text/javascript">
var RecaptchaOptions = {
   theme : 'white'
};
</script>
 
<form method="POST">
    <table>
 
                <tr><td><b>Username:</b></td><td><input type="text" name="login" value="<?php echo $login; ?>"></td></tr>
                <tr><td><b>Password:</b></td><td><input type="password" name="pass"></td></tr>
                <tr><td><b>Repeat:</b></td><td><input type="password" name="pass2"></td></tr>
                <tr><td><b>Email:</b></td><td><input type="text" name="email" value="<?php echo $email; ?>"></td></tr>
                <tr><td><b>Player color:</b></td><td><select name="color"><option value="0">Pick a Color</option><option value="1">Blue</option><option value="2">Green</option><option value="3">Pink</option><option value="4">Black</option><option value="5">Red</option><option value="6">Orange</option><option value="7">Yellow</option><option value="8">Dark Purple</option><option value="9">Brown</option><option value="10">Peach</option><option value="11">Dark Green</option><option value="12">Light Blue</option><option value="13">Lime Green</option><option value="14">Gray *exclusive*</option><option value="15">Aqua</option></select></td></tr>
                <tr><td><b>Answer</td><td><b><script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LeDxtISAAAAAATK90IiWT3LLWkO-ArAK2at05rq"></script>
                  <noscript>
                     <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LeDxtISAAAAAATK90IiWT3LLWkO-ArAK2at05rq" height="300" width="500" frameborder="0"></iframe><br>
                     <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                     </textarea>
                     <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                  </noscript></b></td></tr>
                <tr><td><input type="submit" name="submit" value="Register"></td><td><input type="reset" name="reset" value="Reset"></td></tr>
                </table>
</form>

<?php footer(); ?>