<?php
/**
* @copyright SevenSkies -  TGN Studios
* @author Nifix
* @name SevenSkies.register.php
* @namespace SevenSkies
*/

namespace SevenSkies;

class Register {

    private $utils = null;

    public function __construct() {
        $this->utils = new Utils();
    }
    
    public function sPrintRegiForm()
    {
        $Output = '<br /><div align="center">
                    Welcome on the SevenSkies registration page ! <br />
                    Please ensure to fill all the fields before submitting your registration.<br />
                    - Your passwords must be at least 6 letters length.</div><hr style="width:85%"><br /><div align="center">';
        
        $Output .= '<form method="post" name="Rewgi" action="register.ss"><table id="regitable">';
        $Output .= '<tr><td>First name :</td><td><div align="center" class="eBox"><input class="sEbox" type="text" name="sFirst" /></div></td><td>Last Name :</td><td><div align="center" class="eBox"><input class="sEbox" type="text" name="sLast" /></div></td></tr>';
        $Output .= '<tr><td>Country :</td><td><div align="center" class="eBox"><input class="sEbox" type="text" name="sNation" /></div></td><td>Date of birth :</td><td><div align="center" class="eBox"><input class="sEbox" type="text" id="mydate" name="sDate"  readonly /></div></td></tr>';
        $Output .= '<tr><td>Gender :</td><td><div align="center"><input type="radio" checked name="sGender" value="m"> Male <input type="radio" name="sGender" value="f"> Female</div></td><td>eMail :</td><td><div align="center" class="eBox"><input class="sEbox" type="text" name="seMail" /></div></td></tr>';
        $Output .= '<tr><td>Password :</td><td><div align="center" class="eBox"><input class="sEbox" type="password" name="sPwd" /></td><td>Confirm password :</td><td><div align="center" class="eBox"><input class="sEbox" type="password" name="scPwd" /></div></td></tr>';
        $Output .= '<tr><td>Help word :</td><td><div align="center" class="eBox"><input class="sEbox" type="text" name="sWord" /></td><td>Account name :</td><td><div align="center" class="eBox"><input class="sEbox" type="text" name="sAcc" /></div></td></tr>';
        $Output .= '<tr><td colspan="4"><div align="center">'.recaptcha_get_html($this->utils->getPubkey()).'</div></td></tr>';
        $Output .= '<tr><td colspan="4"><a href="#" onclick="registerSubmit();"><img height="39px" class="imgHover" src="./images/registerb.png" /></a></td></tr>';
        $Output .= '</table></form></div>';
        return $Output;
    }

    /**
     * Add an user.
     * @param string $sUsername Username
     * @param $sEmail eMail
     * @param $sWord Secret word
     * @param $sPass Password
     * @param $scPass Confirmed password
     * @param $sLast Last name
     * @param $sFirst First name
     * @param $sGender Gender, 0 or 1
     * @param $sDate Date, obvious
     * @param $sNation Country
     * @return array $aFail Containing errors during AddUser() process.
     */
    public function AddUser($sUsername,$sEmail,$sWord,$sPass,$scPass,$sLast,$sFirst,$sGender,$sDate,$sNation)
    {
        $aFail = array();
        $sArgs = func_get_args();

        if (count($sArgs) != 10) array_push($aFail,1);
            
        $pUsername = $this->utils->sStrip($sUsername);
        $pEmail = $this->utils->sStrip($sEmail);
        $pWord = $this->utils->sStrip($sWord);
        $pPass = md5($this->utils->sStrip($sPass));
        $pcPass = md5($this->utils->sStrip($scPass));
        
        $pLast = $this->utils->sStrip($sLast);
        $pFirst = $this->utils->sStrip($sFirst);
        $pGender = $this->utils->sStrip($sGender);
        $pNation = $this->utils->sStrip($sNation);
        
        if (empty($pLast) || empty($pFirst) || empty($pGender) || empty($sDate) || empty($sNation)) array_push($aFail,7);
        
        if (preg_match("/([0-9]{2})-([0-9]{2})-([0-9]{2})/i",$sDate)) {
            $pDate = substr($sDate,2);
        } else {
            array_push($aFail,8);
        }
		
        if ($pPass != $pcPass) array_push($aFail,2);

        $cQuery = $this->utils->sQuery('SELECT AID FROM i7skies_core..UserInfo WHERE Account = ?',array($pUsername),false,false);
        if (count($cQuery) > 0) array_push($aFail,3);

        $cQuery = $this->utils->sQuery("SELECT AID FROM i7skies_core..UserInfo WHERE Email = ?",array($pEmail),false,false);
        if (count($cQuery) > 0) array_push($aFail,4);

        if (!preg_match("#^[A-Za-z0-9._-]+@[A-Za-z0-9._-]{2,}\.[a-z]{2,4}$#" , $pEmail)) array_push($aFail,5);
        		
	if (strlen($pPass) < 6) array_push($aFail,6);
        
        $svKey = md5(time() + "Moobi");

        if (count($aFail) < 1) {
            // FirstName LastName Gender BirthDay Nation 
            $this->utils->sQuery("DECLARE @NEWID int SET @NEWID=(select max(AID)+1 from i7skies_core..UserInfo) INSERT INTO i7skies_core..UserInfo (Account,FirstName,LastName,Nation,Gender,BirthDay,MD5Password,MotherLName,Email,[Right],MailIsConfirm,RegDate) VALUES(?,?,?,?,?,?,?,?,?,1,0,getDate())",array($pUsername,$pFirst,$pLast,$pNation,$pGender,$pDate,$pPass,$pWord,$pEmail),false,false);
            $this->utils->sQuery("DECLARE @NEWID int SET @NEWID=(select max(ch_aid)+1 from i7skies_core..user_mail_check) INSERT INTO i7skies_core..user_mail_check (ch_aid,ch_account,ch_pw) VALUES(@NEWID,?,?)",array($pUsername,$svKey),false,false);
            array_push($aFail,0);
            
            
            $pMsg = '<div style="font-style:Tahoma; font-size:11px; color:#696969;">Thank you for registering for Seven Skies Online.<br /><br /> You are required to activate your account online at the following link before you can play. Please check your Forum Pm Box for client link.<br /><br />';
            $pMsg .= '<a href="http://sevenskiesonline.com/finish-'.$pUsername.'-'.$svKey.'" target="_blank">';
            $pMsg .= 'http://sevenskiesonline.com/finish-'.$pUsername.'-'.$svKey;
            $pMsg .= '</a></div>';

            $uMail = new uMail();
            $uMail->SendMail("accounts@sevenskiesonline.com","Registration Server",$pEmail,"New Adventurer","SevenSkies Online Account Activation", $pMsg);
        }
        return $aFail;
    }
    
    /**
    * Used to confirm account.
    *
    * @param string $sAuth Auth Key provided by $_GET['authKey']
    * @return string $sAcc Account Name provided by $_GET['authAcc']
    */
    
    public function authUser($sAuth,$sAcc)
    {
        $sAuth = $this->utils->sStrip($sAuth);
        $sAcc = $this->utils->sStrip($sAcc);
        
        $cQuery = $this->utils->sQuery('SELECT * FROM i7skies_core..user_mail_check WHERE ch_account = ? AND ch_pw = ?',array($sAcc,$sAuth),false,false);
        if (empty($cQuery)) return false;
        
        $this->utils->sQuery('UPDATE i7skies_core..UserInfo SET MailIsConfirm=1 WHERE Account = ?',array($sAcc),false,false);
        $this->utils->sQuery('DELETE FROM i7skies_core..user_mail_check WHERE ch_account = ?',array($sAcc),false,false);
        return true;
    }
}

?>