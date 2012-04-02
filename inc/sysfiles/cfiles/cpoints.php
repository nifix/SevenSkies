<?php
require("./inc/sysfiles/SevenSkies.cp.php");
require("./inc/sysfiles/SevenSkies.points.php");

if (!class_exists("utils"))
{
    $utils = new SevenSkies\Utils();
}
$sp = new \SevenSkies\SkyPoints();
ob_start();

if (!$utils->isLogged())
{
    echo '<div align="center">You have to be logged in to access this page.</div>';
} else {
	if (!isset($_POST['amount']))
	{
		echo $sp->printForm();
	} else {
		echo $sp->printCheckout($_POST['amount']);
	}	
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

            </div>           
        </div> 
    </div>
</div>
<div class="footerContent"></div>

