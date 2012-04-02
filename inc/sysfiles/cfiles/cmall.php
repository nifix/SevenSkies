<?php
require("./inc/sysfiles/SevenSkies.cp.php");
require("./inc/sysfiles/SevenSkies.mall.php");

if (!class_exists("utils"))
{
    $utils = new SevenSkies\Utils();
}

ob_start();
$mall = new SevenSkies\Mall();
if (!$utils->isLogged())
{
    echo '<div align="center">You have to be logged in to access this page.</div>';
} else {
    if (!empty($_GET["cat"]) && !empty($_GET["p"]))
    {
        echo $mall->printCatalog($_GET["p"], $_GET["cat"]);
    } else {
        echo $mall->printCatalog(0,1);
    }
}

$tmp = ob_get_contents();
ob_end_clean();
?>

<div class="ucpHeader"></div>
<div class="mainContent">
    <div class="content">
        <div align="center">
            <div align="center" style="padding-top:10px;"><?php if (!empty($tmp)) echo $tmp; ?></div>           
        </div> 
    </div>
</div>
<div class="footerContent"></div>