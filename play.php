<?php

include 'functions.php';
top('Play');
?>
	<script language="JavaScript">
		<!--
		function resize_iframe()
		{

		 var height=window.innerWidth;//Firefox
		 if (document.body.clientHeight)
		 {
		  height=document.body.clientHeight;//IE
		 }
		 //resize the iframe according to the size of the
		 //window (all these should be on the same line)
		 document.getElementById("glu").style.height=parseInt(height-
		 document.getElementById("glu").offsetTop-8)-150+"px";
		}

		// this will resize the iframe every
		// time you change the size of the window.
		window.onresize=resize_iframe; 

		//Instead of using this you can use: 
		// <BODY onresize="resize_iframe()">


		//-->
		</script>
	<h1 class="center">Play</h1>
	<div style="width: 800px;height: 500px; margin: 5px; margin: 0 auto;">
		<p style="text-align: right"><a href="<?php echo $site['url']; ?>/fullscreen" style="text-align: right;padding: 5px; margin-right: 15px;">Full screen</a></p>
		<center><iframe id="glu" width="100%" onload="resize_iframe()" style="border: 0; margin: 0; padding: 0;" src="http://cfmedia.sexyi.am/Loader.swf"></iframe></center>
	</div>
<?php
footer();
?>