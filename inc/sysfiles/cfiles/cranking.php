<?php
require("./inc/sysfiles/SevenSkies.rank.php");

if (!class_exists("utils"))
{
    $utils = new SevenSkies\Utils();
}

ob_start();

$rank = new SevenSkies\Ranking();
if (isset($_GET["c"]) && isset($_GET["t"])) {
    $c = $utils->sStrip($_GET["c"]);
    $t = $utils->sStrip($_GET["t"]);
    echo $rank->showRank($t,$c);
}
$tmp = ob_get_contents();
ob_end_clean();
?>

<div class="rankHeader"></div>
<div class="mainContent">
    <div class="content">
        <div align="center"><?php if (!empty($tmp)) echo $tmp; ?></div> 
    </div>
</div>
<div class="footerContent"></div>