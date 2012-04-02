<?php
include("./inc/sysfiles/SevenSkies.register.php");
include("./inc/sysfiles/SevenSkies.mail.php");
require_once("./inc/sysfiles/recaptchalib.php");

if (!class_exists("uMail"))
{
    $mail = new SevenSkies\Mailer();
    $utils = new SevenSkies\Utils();
    $register = new SevenSkies\Register();
}

ob_start();
if (!$utils->isLogged()) 
{
    if (isset($_POST['sAcc']))
    {
        $sMode = false;
        $resp = recaptcha_check_answer($utils->getPrikey(),$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
        if ($resp->is_valid) { 
            $sFail = $register->AddUser($_POST['sAcc'],$_POST['seMail'],$_POST['sWord'],$_POST['sPwd'],$_POST['scPwd'],$_POST['sLast'],$_POST['sFirst'],$_POST['sGender'],$_POST['sDate'],$_POST['sNation']);
            if ($sFail[0] == 0) {
                echo '<div align="center"><div class="win">Success !<br />You have successfuly registered your account !<br />Now check your emails !</div></div>';
            } else {
                echo '<div align="center"><div class="fail">Error !<br />';
                foreach ($sFail as $Fail)
                {
                    if ($Fail == 1) { echo "<li>Didn't fill out every field</li>"; }
                    else if ($Fail == 2) { echo "<li>Your passwords don't match.</li>"; }
                    else if ($Fail == 3) { echo "<li>This account name is already taken.</li>"; }
                    else if ($Fail == 4) { echo "<li>This eMail is already in use.</li>"; }
                    else if ($Fail == 5) { echo "<li>This eMail has an incorrect format.</li>"; }
                    else if ($Fail == 6) { echo "<li>Your password must be at least 6 letters length.</li>"; }
                    else if ($Fail == 7) { echo "<li>You didn't fill everything correctly. Please do it again.</li>"; }
                    else if ($Fail == 8) { echo "<li>Don't try to exploit the date that's already been done.</li>"; }
                }
            
                echo "</div></div>";
            }        

        } else {
            echo '<div align="center"><div class="fail">Error !<br /> Wrong Captcha !</div></div>';
        }
    } else if (!empty($_GET['authKey']) && !empty($_GET['authAcc']))
    {
        $sMode = true;
        if ($register->authUser($_GET['authKey'],$_GET['authAcc']))
        {
            echo '<div align="center"><div class="win">Congratulations '.$utils->sStrip($_GET['authAcc']).' !<br /><br />You have successfully confirmed your account, have fun on SevenSkies Online !</div></div>';
            
            } else {
            echo '<div align="center"><div class="fail">Error !<br /><br /> Wrong auth key/account combo !</div></div>';
        }
    }
}

$sTmp = ob_get_contents();
echo $sTmp;
ob_end_clean();
?>

<div class="headerContent"></div>
<div class="mainContent">
    <div class="content">
        <div align="center">
                <?php 
                    if (!empty($sTmp)) echo $sTmp;
                    if (((!isset($sMode)) || (!$sMode)) && $utils->isLogged() === FALSE) echo $register->sPrintRegiForm();
                    else { echo "You're already registered !"; }
                ?> 
        </div>
    </div>
</div>
<div class="footerContent"></div>


