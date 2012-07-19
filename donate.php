<?php

include 'functions.php';
top('Donate');
?>
<h1>Donate</h1>
<small style="color:red">This is considered a donation, not a payment. No refunds will be issued, in any case</small>
<div style="float: left; margin-right: 5px;">
    <img src="images/donate.png" alt="Donate" height="230" />
</div>
<p>Want to help iClubX grow? Donating is a great way to do so! You give us some money though PayPal. <p>All those money go straight to the creators of the server, and will help it grow. But wait, this isn't everything! You even get a Moderator position for life, if you donate using the form below ($20)!</p> Alternatively, you can donate to avbincco@gmail.com, any amount.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" a>
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="QRC8C7NNXSRU6">
    <table>
        <tr><td><input type="hidden" name="on0" value="Username">Username</td></tr><tr><td><input type="text" name="os0" maxlength="200"></td></tr>
    </table>
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php footer(); ?>