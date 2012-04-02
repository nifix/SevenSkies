<?php
require("./inc/sysfiles/SevenSkies.points.php");
require("./inc/sysfiles/SevenSkies.mail.php");
$utils = new \SevenSkies\Utils();
$mail = new \SevenSkies\Mailer();

// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header = "";
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$id_user = $_POST['custom'];

function VerifIXNID($txn)
{
    $utils = new \SevenSkies\Utils();
    $data = $utils->sQuery("SELECT * FROM dd_payments WHERE txnid = ?",array($txn),false,true);
    return (empty($data)) ? 0 : 1;
}
                  
if (!$fp) {
// HTTP ERROR
} else {
    $points = array("5.00"=>"500","9.00"=>"1000","13.00"=>"1500");
    fputs ($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets ($fp, 1024);
        if (strcmp ($res, "VERIFIED") == 0) {
        // check the payment_status is Completed
        // check that txn_id has not been previously processed
        // check that receiver_email is your Primary PayPal email
        // check that payment_amount/payment_currency are correct
        // process payment
            if ($payment_status == "Completed")
            {
                if (VerifIXNID($txn_id) == 0)
                {
                    if (in_array($payment_amount,$points)) 
                    {
                        if ($receiver_email == Conf::EMAIL_PAYPAL) 
                        {          
                            $data = array($item_name,$item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$id_user,"SUCCESS : Payment successfully processed.");
                            $utils->sQuery("INSERT INTO `ss_payments` (`itemname`, `itemnumber`, `status`, `amount`, `currency`, `txnid`, `receivemail`, `payeremail`, `account`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",$data,true,true); 
                            $curbalance = $utils->sQuery("SELECT SkyPoints FROM i7skies_core..UserInfo WHERE Account = ?",array($id_user),false,false);
                            $newb = $curbalance[0]["SkyPoints"]+$points[$payment_amount];
                            //$mail->SendMail("accounts@sevenskiesonline.com","Payment API","nifix.dev@gmail.com","Hello","Paid", "PAID OMG.");
                            $utils->sQuery("UPDATE i7skies_core..UserInfo SET SkyPoints = $newb WHERE Account = ?",array($id_user),true,false);                      
                        } else {
                            $data = array($item_name,$item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$id_user,"ERROR : Wrong receiver eMail.");
                            $utils->sQuery("INSERT INTO `ss_payments` (`itemname`, `itemnumber`, `status`, `amount`, `currency`, `txnid`, `receivemail`, `payeremail`, `account`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",$data,true,true);
                        }
                    } else {
                        $data = array($item_name,$item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$id_user,"ERROR : Payment amount not valid.");
                        $utils->sQuery("INSERT INTO `ss_payments` (`itemname`, `itemnumber`, `status`, `amount`, `currency`, `txnid`, `receivemail`, `payeremail`, `account`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",$data,true,true);                        
                    }
                } else {
                        $data = array($item_name,$item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$id_user,"ERROR : Transaction ID already used.");
                        $utils->sQuery("INSERT INTO `ss_payments` (`itemname`, `itemnumber`, `status`, `amount`, `currency`, `txnid`, `receivemail`, `payeremail`, `account`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",$data,true,true);
                }
            } else {
                $data = array($item_name,$item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$id_user,"ERROR : Payment not completed successfully.");
                $utils->sQuery("INSERT INTO `ss_payments` (`itemname`, `itemnumber`, `status`, `amount`, `currency`, `txnid`, `receivemail`, `payeremail`, `account`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",$data,true,true);
            }
        } else if (strcmp ($res, "INVALID") == 0) {
            $data = array($item_name,$item_number,$payment_status,$payment_amount,$payment_currency,$txn_id,$receiver_email,$payer_email,$id_user,"ERROR : Payment marked as INVALID.");
            $utils->sQuery("INSERT INTO `ss_payments` (`itemname`, `itemnumber`, `status`, `amount`, `currency`, `txnid`, `receivemail`, `payeremail`, `account`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",$data,true,true);
        }
    }
    fclose ($fp);
}
?>


<div class="ucpHeader"></div>
<div class="mainContent">
    <div class="content">
        <div align="center">
            <div align="center" style="padding-top:10px;">

                MoO<3

                </form>
            </div>           
        </div> 
    </div>
</div>
<div class="footerContent"></div>