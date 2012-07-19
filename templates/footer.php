<?php 

if (mb_strstr($_SERVER["PHP_SELF"], "template/footer.php", "UTF-8")) {
    die('<h1>Access denied!</h1>');
}

include 'config.inc.php'; 
?>
            </div>
            <div id="footer">
                <div class="powered-by">
                    <a href="http://php.net"><img src="<?php echo $site['url']?>/images/php.png" alt="PHP Logo"></a>
                    <a href="http://mysql.com"><img src="<?php echo $site['url']?>/images/mysql.png" alt="MySQL Logo"></a>
                    <a href="http://www.w3.org/html"><img src="<?php echo $site['url']?>/images/html.png" alt="HTML5 Logo"></a>
                    <a href="http://jquery.com"><img src="<?php echo $site['url']?>/images/jquery.png" alt="jQuery Logo"></a>
                </div>
                <p class="policy"><a href="<?php echo $site['url']?>/policy">Privacy Policy</a></p>
                <div class="copyright">&copy; 2012 <a href="http://avbinc.org">AVB Inc.</a> All rights reserved!</div>
            </div>
        </div>
    </body>
</html>
<script>
            height=$(window).height()-300;
            
            $('#content').css('min-height',height+"px")</script>