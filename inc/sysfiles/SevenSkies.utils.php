<?php 
/**
 * 
 * SevenSkies - Utils class
 * @author Nifix
 * 
 */
namespace SevenSkies;

class Utils
{
    private $ldb;
    // friteuse
    
    /**
     * Creates and executes a query.
     * @param string $sData SQL Query
     * @param array $sArgs Array containing the args
     * @param bool $sMode false to gather datas or true to just execute
     * @param bool $sType false for MsSQL true for MySQL
     * @return array Datas
     */
    public function sQuery($sData = "",$sArgs = array(),$sMode = false, $sType = true)
    {

        if (!$this->ldb) {
            try {
                switch ($sType) {
                    case false: $this->ldb = new \PDO('sqlsrv:server='.Conf::MS_HOST.';Database='.Conf::MS_DB,Conf::MS_LOGIN,Conf::MS_PWD);
                break;
                    case true: $this->ldb = new \PDO('mysql:host='.Conf::MY_HOST.';dbname='.Conf::MY_DB,Conf::MY_LOGIN,Conf::MY_PWD);
                break;
                }
            } catch (PDOException $e) {
                echo "SevenSkies Database Error : ".$e->getMessage()."\n";
                exit;
            }
        }
        if ($sMode) {
            $Q = $this->ldb->prepare($sData);
            $Q->execute($sArgs);
        } else {
            $Q = $this->ldb->prepare($sData);
            $Q->execute($sArgs);
            $Q = $Q->fetchAll();
        }
        $this->ldb = null;
        return (is_array($Q)) ? $Q : true;
    }
    
    /**
    * Function that strips all the special chars
    *
    * @param string $sString text to parse
    * @return string $sString text parsed.
    */
    
    public function sStrip($sString)
    {
        $sChars = array(',',';','(',')','/','\\',']','[','+','=','^','<','>','&','"');
        foreach($sChars as $sNotAllowed) $sString = str_replace($sNotAllowed,'',$sString);
        return $sString;    
    }
    
    public function sLoadContent($sID)
    {
        $sFiles = array('1'=>'cindex.php','2'=>'cregister.php','3'=>'cdownloads.php',
            '4'=>'cranking.php','10'=>'cphome.php','11'=>'cpasswd.php','12'=>'cchars.php','13'=>'cmall.php','14'=>'cmallbuy.php',
            '15'=>'cpoints.php','16'=>'csuccess.php','17'=>'ccancel.php','18'=>'cnotify.php');
        $nSid = $this->sStrip($sID);
        if (($sID != $nSid) OR (strlen($sID) > 2)) { include(Conf::CFG_INCDIR.'chaxxor.php'); }
        elseif (array_key_exists($sID,$sFiles)) { include(Conf::CFG_INCDIR.$sFiles[$nSid]); }
    }
    
    public function getMenu()
    {
        $output = '<div class="menu" style="padding-left:10px; padding-top:30px;">';
        $output .= '<div class="botmenu"><a href="#">How to play</a></div>';
        $output .= '<div class="botmenu"><a href="#">Story Line</a></div>';
        $output .= '<div class="botmenu"><a href="#">Classes</a></div>';
        $output .= '<div class="botmenu"><a href="#">Medias</a></div>';
        $output .= '<div class="botmenu"><a href="ranking-0.ss">Level rankings</a></div>';
        $output .= '<div class="botmenu"><a href="rankingpvp-1.ss">PvP rankings</a></div></div>';
        return $output;
    }

    public function getLForm()
    {
         $form = '<form name="Lowgin" method="post" action="login.ss">
            <div align="center" class="mcontainer">
                Username<br />
                <div align="center" class="eBox"><input onfocus="this.value=\'\'" class="sEbox" value="Login" name="sLogin" /></div>
                Password<br />
                <div align="center" class="eBox"><input onfocus="this.value=\'\'" class="sEbox" value="Password" type="password" name="sPassword" /></div>
            </div>
            <div align="center" style="padding-left:3px;"><a href="#" onclick="loginSubmit();"><img class="imgHover" src="./images/Loginb.png" /></a></div>
            <div align="center" style="padding-top:6px;">Lost password ?</div>
        </form>';

        if ($this->isLogged())
        {
            $op = '<div align="center" class="mcontainer">Welcome <b>'.$_SESSION['UID'].' !</b><br />';
            $op .= '<div style="padding-top:10px; padding-bottom:10px;">Sky Points : '.$this->getSP($_SESSION['UID']).'</div>';
            $op .= '<div class="menu"><div class="botmenu"><a href="cphome.ss">CP Home</a></div>';
            $op .= '<div class="botmenu"><a href="chpasswd.ss">Change Password</a></div>';
            $op .= '<div class="botmenu" style="margin-right:16px;"><a href="characters.ss">My Characters</a></div>';
            $op .= '<div class="botmenu" style="margin-right:16px;"><a href="catalog-1-1.ss">Item Mall</a></div>';
            $op .= '<div class="botmenu" style="margin-right:16px;"><a href="logout.ss">Logout !</a></div>';
            $op .= '</div></div>';
        } else { $op = $form; }

        return $op;
    }
    
    private function getSP($uid)
    {
        $data = $this->sQuery("SELECT SkyPoints FROM i7skies_core..UserInfo WHERE Account = ?",array($_SESSION['UID']),false,false);
        $_SESSION['SP'] = $data[0]["SkyPoints"];
        return $data[0]["SkyPoints"];
    }
    public function isLogged()
    {
        if (isset($_SESSION['UID']) && isset($_SESSION['E']) && isset($_SESSION['R']) && isset($_SESSION['SP']))
        {
            return true;
        } else { return false; }
    }
    
    public function getJob($id)
    {
        $jobs = array('0'=>'Visitor','111'=>'Soldier','121'=>'Knight',
                  '122'=>'Champion','211'=>'Muse','221'=>'Mage',
                  '222'=>'Cleric','311'=>'Hawker','321'=>'Raider',
                  '322'=>'Scout','411'=>'Dealer','421'=>'Bourgeois',
                  '422'=>'Artisan','131'=>'Paladin','132'=>'Crusader',
                  '133'=>'Gladiator','134'=>'Mercenary','231'=>'Wizard',
                  '232'=>'Sage','233'=>'Priest','234'=>'Monk','331'=>'Assassin',
                  '332'=>'Rogue','333'=>'Hunter','334'=>'Ranger','431'=>'Sniper',
                  '432'=>'Outlaw','433'=>'Mechanic','434'=>'Alchemist');
        return $jobs[$id];
    }
    
    function __destruct() {
        $this->ldb = null;
    }
   
    public function getPubkey() { return Conf::RECAP_KEY; }
    public function getPrikey() { return Conf::RECAP_PKEY; }
}

?>