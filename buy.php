<?php
include 'functions.php';
top('Buy items');
if(!$_GET['what']){
echo '<table>
<tr><td>
<div style="border:1px solid #afffb5;width:400px;padding:5px">
<img src="'.$site['url'].'/images/nameglow.png"><br>
Nameglow is a great way to get out of the crowd! <br>Your name will be light in the dark, and everyone will see it!
<br>
Price:<i>50 points</i>
<a href="buy/nameglow" class="button">Buy now</a>
</div></td></tr>    
</table>';
}
footer();