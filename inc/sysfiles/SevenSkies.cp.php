<?php
/**
 * Control Panel SevenSkies
 *
 * @author Nifix
 */
namespace SevenSkies;

class ControlPanel {

    /** 
    * @var mixed $utils Handle for the utils class. 
    */
    private $utils = null;
    /**
    * @var mixed $hexfunc Handle for the HexFuncs class.
    */
    private $hexfunc = null;
    /**
    * @var string $uid String containing an user ID.
    */
    private $uid = '';
    

    /**
    *
    * Initializing some variables/classes.
    *
    * @return void
    *
    */

    public function __construct($uid)
    {
        $this->utils = new Utils();
        $this->uid = $uid; 
    }
    
    /**
    *
    * Grabs the infos about the account from SQL Server db.
    *
    * @return data[] array containing the infos.
    *
    */

    private function gatherData()
    {
        $data = $this->utils->sQuery('SELECT * FROM i7skies_core..UserInfo WHERE Account = ?',array($this->uid),false,false);
        return $data;
    }
	
    /**
    *
    * Grabs the map name from the MySQL database.
    *
    * @return string Name of the map.
    *
    */

    private function getMapid($id)
	{
		$data = $this->utils->sQuery('SELECT * FROM ss_zones WHERE id = ?',array($id),false,true);
		return $data[0]["name"];
	}

    /**
    *
    * Prints the account status on the Control Panel Homepage. 
    *
    * @return string HTML Block of text.
    *
    */

    public function printData()
    {
        $data = $this->gatherData();
        
        $isConfirm = ($data[0]["MailIsConfirm"] == 1) ? "Confirmed" : "Not Confirmed";
        
        $output = '<table><caption>Account Informations</caption><tbody>';
        $output .= '<tr><td><b>Account name :</b></td><td>'.$data[0]["Account"].'</td></tr>';
        $output .= '<tr><td><b>First name :</b></td><td>'.$data[0]["FirstName"].'</td></tr>';
        $output .= '<tr><td><b>Last name :</b></td><td>'.$data[0]["LastName"].'</td></tr>';
        $output .= '<tr><td><b>Email :</b></td><td>'.$data[0]["EMail"].'</td></tr>';
        $output .= '<tr><td><b>Register date :</b></td><td>'.$data[0]["RegDate"].'</td></tr>';
        $output .= '<tr><td><b>Nation :</b></td><td>'.$data[0]["Nation"].'</td></tr>';
        $output .= '<tr><td><b>Birthday :</b></td><td>'.$data[0]["BirthDay"].'</td></tr>';
        $output .= '<tr><td><b>Account status :</b></td><td>'.$isConfirm.'</td></tr></tbody>';
        $output .= '</table>';
        echo $output;
    }
    
    /**
    *
    * Prints the form to change the password.
    *
    * @return string HTML Block of text.
    *
    */

    public function printFormChpass()
    {
        
        $output = '<form method="post" name="chpass" action="chpasswd.ss"><table>';
        $output .= '<caption>Change your password</caption><tbody>';
        $output .= '<tr><td><b>Current password : </b></td><td><div align="center" class="eBox"><input class="sEbox" type="password" name="oldPwd" /></div></td></tr>';
        $output .= '<tr><td><b>New password : </b></td><td><div align="center" class="eBox"><input class="sEbox" type="password" name="nPwd" /></div></td></tr>';
        $output .= '<tr><td><b>Confirm new password : </b></td><td><div align="center" class="eBox"><input class="sEbox" type="password" name="ncPwd" /></div></td></tr>';
        $output .= '<tr><td colspan="2"><div style="float:right"><input type="submit" Value="Change it !" /></div></td></tr></tbody>';
        $output .= '</table></form>';
        echo $output;
    }
    
    /**
    *
    * Function that changes the password
    * Called after submitting the form.
    *
    * @param string $oldPwd Old password.
    * @param string $nPwd New password.
    * @param string $ncPwd New password confirmation.
    * @return err[] Array of errors.
    *
    */

    public function processChpass($oldPwd,$nPwd,$ncPwd)
    {
        $err = array();
        
        $data = $this->utils->sQuery('SELECT MD5Password FROM i7skies_core..UserInfo WHERE Account = ?',array($this->uid),false,false);
        $dbpasswd = $data[0]["MD5Password"];
        
        $oldPwd = $this->utils->sStrip($oldPwd);
        $nPwd = $this->utils->sStrip($nPwd);
        $ncPwd = $this->utils->sStrip($ncPwd);
    
        $pOldPwd = md5($oldPwd);
        $pnPwd = md5($nPwd);
        $pncPwd = md5($ncPwd);
        
        if (empty($oldPwd) || empty($nPwd) || empty($ncPwd)) array_push($err,1);
        
        if ($dbpasswd != $pOldPwd) array_push($err,2);
        
        if ($pnPwd != $pncPwd) array_push($err,3);
        
        if (count($err) < 1) {
            $this->utils->sQuery('UPDATE i7skies_core..UserInfo SET MD5Password = ? WHERE Account = ?',array($pnPwd,$this->uid),false,false);
            array_push($err,0);
        }
        return $err;
    }
	
    /**
    *
    * Gets gender, pretty obvious.
    *
    * @param integer $val Hexadecimal value.
    * @return integer Gender type, 1 or 0.
    *
    */

	public function getGender($val)
	{
		return $val & 0x01;
	}
	
    /**
    *
    * Gets the race
    * 
    * @param integer $val Hexadecimal value.
    * @return string Race name.
    *
    */

	public function getRace($val)
	{
		$raceids = array(0=>"Junon",1=>"Luna",2=>"Eldeon");
		$result = floor($val / 0x02);
		return $raceids[$result];
	}
	
    /**
    *
    * Grabs the characters linked to an account.
    *
    * @return string HTML Block of text.
    *
    */

    public function gatherChars()
    {
        $this->hexfunc = new HexFuncs();
        $output = '';
        $data = $this->utils->sQuery('SELECT * FROM i7skies..tblGS_AVATAR WHERE txtACCOUNT = ? ORDER BY btLEVEL DESC',array($this->uid),false,false);
        for ($i=0; $i<count($data); $i++)
        {
            $str = $this->hexfunc->getWord($data[$i]["binBasicA"], 0);
            $dex = $this->hexfunc->getWord($data[$i]["binBasicA"], 4);
            $int = $this->hexfunc->getWord($data[$i]["binBasicA"], 8);
            $con = $this->hexfunc->getWord($data[$i]["binBasicA"], 12);
            $cha = $this->hexfunc->getWord($data[$i]["binBasicA"], 16);
            $sen = $this->hexfunc->getWord($data[$i]["binBasicA"], 20);
			$map = $this->hexfunc->getWord($data[$i]["binBasicE"], 18);
			$hp = $this->hexfunc->getWord($data[$i]["binGrowA"], 0);
			$mp = $this->hexfunc->getWord($data[$i]["binGrowA"], 4);
			$coord_x = $this->hexfunc->getCoord($this->hexfunc->getDWord($data[$i]["binBasicE"], 0));
			$coord_y = $this->hexfunc->getCoord($this->hexfunc->getDWord($data[$i]["binBasicE"], 8));
			$gender = $this->getGender($this->hexfunc->getByte($data[$i]["binBasicE"], 16));
			$gender = ($gender == 1) ? "girl.png" : "man.png";
			$race = $this->getRace($this->hexfunc->getByte($data[$i]["binBasicE"], 16));
            $output .= '<table><caption>'.$data[$i]["txtNAME"].'</caption><tbody>';
            $output .= '<tr><td rowspan="3"><img src="images/icons/'.$gender.'" alt="Picture !" /></td><td width="150" colspan="2">Class : <b>'.$this->utils->getJob($data[$i]["intJOB"]).'</b></td>';
            $output .= '<td>Level : <b>'.$data[$i]["btLEVEL"].'</b></td><td>Race : <b>'.$race.'</b></td><td colspan="4" width="100">Money : <b>'.$data[$i]["intMoney"].'</b></td></tr>';
            $output .= '<tr><td>X : <b>'.$coord_x.'</b></td><td>Y : <b>'.$coord_y.'</b></td><td colspan="2" width="180">Map : <b>'.$this->getMapid($map).'</b></td><td colspan="2" style="background-color:#D6586D; color:white;">HP : <b>'.$hp.'</b></td><td style="background-color:#58BBD6; color:white;">MP : <b>'.$mp.'</b></td></tr>';
            $output .= '<tr><td>STR : <b>'.$str.'</b></td><td>DEX : <b>'.$dex.'</b></td><td>INT : <b>'.$int.'</b></td><td>CON : <b>'.$con.'</b></td><td colspan="2">CHA : <b>'.$cha.'</b></td><td>SEN : <b>'.$sen.'</b></td></tr>';
            $output .= '</tbody></table><br />';  
        }
        return $output;
    }
}

?>
