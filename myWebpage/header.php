 <?session_start();?>
 <meta charset="utf-8">
 <?
                if(!$userid)
                {
                ?>      
            <li><a href="./login_page.html">login</a></li>
                <?
                }
                else
                {
                ?>
            <li><a href="./login/logout.php">logout</a></li>
            <?
                }
                ?>