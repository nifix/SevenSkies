<?php
require("./inc/sysfiles/SevenSkies.cp.php");
require("./inc/sysfiles/SevenSkies.hexfuncs.php");

if (!class_exists("utils"))
{
    $utils = new SevenSkies\Utils();
}

ob_start();
if (!$utils->isLogged())
{
    echo '<div align="center">You have to be logged in to access this page.</div>';
} else {
$cp = new SevenSkies\ControlPanel($utils->sStrip($_SESSION["UID"]));
echo $cp->gatherChars();
}

$tmp = ob_get_contents();
ob_end_clean();
?>

<div class="ucpHeader"></div>
<div class="mainContent">
    <div class="content">
        <div align="center">
            <?php if (!empty($tmp)) echo $tmp; ?>           
        </div> 
    </div>
</div>
<div class="footerContent"></div>


