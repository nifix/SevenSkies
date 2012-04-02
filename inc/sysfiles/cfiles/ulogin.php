<?php
session_start();
include("../../../config/SevenSkies.config.php");
include("../SevenSkies.utils.php");
include("../SevenSkies.login.php");
if ($_GET["a"] == 1) {
    $login = new \SevenSkies\Login($_POST['sLogin'],$_POST['sPassword']);
    $rl = $login->getErr();
    $op = "";
    if ($rl[0] != 2) $op .= "Following errors happened :<br />";
    foreach($rl as $err)
    {
        if ($err == 2) { $op .= "Successfully logged in.<br />"; }
        else if ($err == 1) { $op .= "Passwords don't match.<br />"; }
        else if ($err == 0) { $op .= "Account doesn't exist.<br />"; }
    }
    echo $op;
	print_r($_SESSION);
    header("refresh: 1; url=http://direct.sevenskiesonline.com:1337");
} else if ($_GET["a"] == 0) {
    session_unset();
    session_destroy();
    header("refresh: 1; url=http://direct.sevenskiesonline.com:1337");
}
?>