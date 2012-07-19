<?php
include 'functions.php';
top('Login');
if($_SESSION['il']){
    rr('index.php');
}
echo '<img src="images/login.png" style="float:right">';
if($_POST['act']=='Login'){
    mysql_select_db($site['game_db']);
    $q=  query('SELECT * FROM users WHERE username="'.mysql_real_escape_string($_POST['username']).'" AND password="'.md5($_POST['password']).'"');
    if(mysql_num_rows($q)){
        $_SESSION['ui']=  assoc($q);
        $_SESSION['il']=1;
        rr('index.php');
    }
    else{
        echo '<div class="error">Incorrect username/password combination!</div>';
    }
    
}
echo 'In order to use our web-panel, buy things, get special rewards, and so on. You need to be logged in. You can use your in-game account to do this. If you don\'t have one, go ahead and <a href="register.php">register</a>! You will be using this account in both the website and the game. And, login every-day for gifts ;)
    <br><form method="post"><table>
<tr><td>Username</td><td><input type="text" name="username"></td></tr>    
<tr><td>Password</td><td><input type="password" name="password"></td></tr> 
<tr><td></td><td><input type="submit" name="act" value="Login"></td></tr>
</table></form>
<br>
Did you <a href="forget.php">Forget your password?</a><br><br><br><br><br><br><br><br>';

footer();