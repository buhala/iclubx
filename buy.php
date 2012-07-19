<?php
include 'functions.php';
top('Buy items');
if(!$_SESSION['il']){
    rr($site['url'].'/login');
}
if(!$_GET['what']){
echo '<table>
<tr><td>
<div style="border:1px solid #afffb5;width:400px;padding:5px">
<img src="'.$site['url'].'/images/nameglow.png"><br>
Nameglow is a great way to get out of the crowd! <br>Your name will be light in the dark, and everyone will see it!
<br>
Price:<i>50 points</i>
<a href="buy/nameglow" class="button">Buy now</a>
</div></td>
<td>
<div style="border:1px solid #afffb5;width:400px;padding:5px">
<img src="'.$site['url'].'/images/bubble.png" height=125"><br>
Want everyone to see your messages? A coloured bubble is a great way to do it. Your messages will be coloured in the color you choose. Everyone will surely notice them
<br>
Price:<i>100 points</i>
<a href="buy/bubble" class="button">Buy now</a>
</div></td></tr>  
<tr><td>
<div style="border:1px solid #afffb5;width:400px;padding:5px">
<img src="'.$site['url'].'/images/stripe.png" height=125"><br>
Want everyone to notice you when they click your playercard? A stripe is an awesome way to do it. You will get an extra line under your player card!
<br>
Price:<i>25 points</i>
<a href="buy/stripe" class="button">Buy now</a>
</div>
</td></tr>
</table>';
}
else{
    mysql_select_db($site['game_db']);
    $q=query('SELECT * FROM rewards WHERE name="'.escape($_GET['what']).'"');
    if(!mysql_num_rows($q)){
        rr($site['url'].'/buy');
    }
    else
        $mypoints=$_SESSION['ui']['points'];
 
        $item=  mysql_fetch_assoc($q);
           $price=$item['price'];
        if($mypoints>$price){
$_SESSION['ui']['points']=$mypoints-$price;
mysql_query('UPDATE users SET points='.$_SESSION['ui']['points'].' WHERE id='.$_SESSION['ui']['id']);
if($_GET['what']=='nameglow'){
   echo '<script src="'.$site['url'].'/js/jscolor.js"></script>';
   echo '<form method="post">
       Name color:(Click to change)<input type="text" class="color" name="namecolor"><br>
       Glow color:(Click to change)<input type="text" class="color" name="glowcolor"><br>
       <input type="submit" name="act" value="Go"></form>';
   if($_POST['act']=='Go'){
       mysql_query('INSERT INTO nameglow (user_id,nick_color,glow_color,user_name)
           VALUES('.$_SESSION['ui']['id'].',"'.  mysql_real_escape_string($_POST['namecolor']).'","'.escape($_POST['glowcolor']).'","'.escape($_SESSION['ui']['username']).'")');
   echo 'Nameglow added successfully!';
       
   }
}
elseif($_GET['what']=='bubble'){
     echo '<script src="'.$site['url'].'/js/jscolor.js"></script>';
     echo '<form method="post">Bubble color(Click to change)<input type="text" name="color" class="color"><br>
         <input type="submit" name="act" value="Go"></form>';
     if($_POST){
         mysql_query('INSERT INTO bubble(user_id,user_name,color)
             VALUES('.$_SESSION['ui']['id'].',"'.escape($_SESSION['ui']['username']).'","'.escape($_POST['color']).'")');
         echo 'Your chat bubble was added successfully!';
     }
}
elseif($_GET['what']=='stripe'){
    if($_SESSION['ui']['rank']>=4){
        echo 'You already have the maximum number of stripes';
    }
    else{
        $_SESSION['ui']['rank']++;
        mysql_query('UPDATE users SET rank='.$_SESSION['ui']['rank'].' WHERE id='.$_SESSION['ui']['id']);
        echo 'Added it successfully ;)';
    }
}

         
        }
else{
echo 'You don\'t have enough points. You have '.$_SESSION['ui']['points'].' points. If you beleive this is a mistake, please re-login and then, contact support!';
 
}
    
}
footer();