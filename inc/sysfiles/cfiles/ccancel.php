<?php
require("./inc/sysfiles/SevenSkies.cp.php");

if (!class_exists("utils"))
{
    $utils = new SevenSkies\Utils();
}
ob_start();

if (!$utils->isLogged())
{
    echo '<div align="center">You have to be logged in to access this page.</div>';
} else {
    echo '<div align="center"><h3>Payment Canceled !</h3>Seems like you canceled your payment, we\'re sadened of this decision but we still wish you
        the best on SevenSkies Online !</div>';
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