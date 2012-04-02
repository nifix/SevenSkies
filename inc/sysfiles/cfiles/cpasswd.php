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
    die();
} else {
    $cp = new SevenSkies\ControlPanel($_SESSION['UID']);
    if (!empty($_POST["oldPwd"]) && !empty($_POST["nPwd"]) && !empty($_POST["ncPwd"]))
    {
        $err = $cp->processChpass($_POST["oldPwd"],$_POST["nPwd"],$_POST["ncPwd"]);
        if ($err[0] == 0) {
            echo '<div align="center"><div class="win">Success !<br />Your password has been successfully changed !</div></div>';
        } else {
            echo '<div align="center"><div class="fail">Error !<br />';
            foreach ($err as $error)
            {
                if ($error == 1) { echo "<li>Didn't fill out every field</li>"; }
                else if ($error == 2) { echo "<li>The current password given is wrong.</li>"; }
                else if ($error == 3) { echo "<li>You didn't confirm your new password correctly.</li>"; }
            }
            echo '</div></div>';
            
           $cp->printFormChpass();
        }
    } else {
        $cp->printFormChpass();
    }
}

$tmp = ob_get_contents();
ob_end_clean();
?>

<div class="ucpHeader"></div>
<div class="mainContent">
    <div class="content">
        <div align="center"><?php if (!empty($tmp)) echo $tmp; ?></div> 
    </div>
</div>
<div class="footerContent"></div>