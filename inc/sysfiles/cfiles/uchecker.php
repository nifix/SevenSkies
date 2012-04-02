<?php
header("Content-Type: text/html;");
include("./../SevenSkies.checky.php");
include("./../../../config/SevenSkies.config.php");
$checky = new SevenSkies\Checky();
echo $checky->toggleStatus();

?>