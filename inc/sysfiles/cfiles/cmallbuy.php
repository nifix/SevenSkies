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
    if (isset($_POST['confirmb'])) {
        $data = $mall->buyItem($_GET["cat"],$_GET["id"]);
        if ($data != false) echo $data;
        else { echo "An error happened ."; }
    } else {
        $mall->checkItem($_GET["cat"],$_GET["id"]);    
    }
}

$tmp = ob_get_contents();
ob_end_clean();
?>
<div id="dialog-confirm" title="Purchase confirmation">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You're going to purchase this item, are you sure ?</p>
</div>
<div class="ucpHeader"></div>
<div class="mainContent">
    <div class="content">
        <div align="center">
            <div align="center" style="padding-top:10px;"><?php if (!empty($tmp)) echo $tmp; ?></div>           
        </div> 
    </div>
</div>
<div class="footerContent"></div>