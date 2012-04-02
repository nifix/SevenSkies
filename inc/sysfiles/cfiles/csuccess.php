<?php
require("./inc/sysfiles/SevenSkies.cp.php");
require("./inc/sysfiles/SevenSkies.points.php");

if (!class_exists("utils"))
{
    $utils = new SevenSkies\Utils();
}

ob_start();

if (!$utils->isLogged())
{
    echo '<div align="center">You have to be logged in to access this page.</div>';
} else {
    echo '<div align="center"><h3>Congratulations !</h3>
        Your payment has been validated and your points should appear in your account very soon (usually instant).<br /><br />We would like to thank you for your support and wish you the best on SevenSkies Online !</div>';
}

$tmp = ob_get_contents();
ob_end_clean();
?>


<div class="ucpHeader"></div>
<div class="mainContent">
    <div class="content">
        <div align="center">
            <div align="center" style="padding-top:10px;">

            	<?php if (!empty($tmp)) echo $tmp; ?>

				</form>
            </div>           
        </div> 
    </div>
</div>
<div class="footerContent"></div>