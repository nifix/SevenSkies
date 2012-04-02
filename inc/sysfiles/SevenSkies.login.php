<?php
/**
 * 
 * Login/Logout class for SevenSkies Website.
 * 
 * @author Nifix
 * 
 */
namespace SevenSkies;

class Login {

    /**
    * @var acc[] Will contain account informations.
    */
    protected $acc = array();
    /**
    * @var err[] Will contain errors during process.
    */
    protected $err = array();
    /**
    * @var mixed Will contain the utils class.
    */
    private $utils = null;

    /**
    *
    * Initialize utils class and launches the process. 
    *
    * @param string $uid Username.
    * @param string $pwd Password.
    * @return void
    *
    */

    function __construct($uid,$pwd)
    {
        $this->utils = new Utils();
        $this->err = $this->gatherData($uid,$pwd);
    }

    /**
    *
    * Getter for the errors.
    *
    * @return err[]
    *
    */

    public function getErr()
    {
        return $this->err;
    }
    
    /**
    *
    *  Logs the user in if everything is correct
    *
    * @param string $uid Username
    * @param string $pwd Password
    * @return err[] Array of errors
    *
    */

    private function gatherData($uid,$pwd)
    {
        $err = array();
        // First, strips the args
        $uid = $this->utils->sStrip($uid);
        $pwd = $this->utils->sStrip($pwd);

        // Gathers data
        $this->acc = $this->utils->sQuery('SELECT * FROM i7skies_core..UserInfo WHERE Account = ?',array($uid),false,false);

        // Account check
        if (count($this->acc) < 1) array_push($err,0);
        $this->acc = $this->acc[0];

        // Then, check if the pwd is correct.
        if (md5($pwd) != $this->acc["MD5Password"]) array_push($err,1);

        // Everything is alright ? Set session vars.
        if (count($err) == 0)
        {
            $_SESSION['UID'] = $this->acc['Account'];
            $_SESSION['E'] = (empty($this->acc['EMail'])) ? "adm@sevenskiesonline.com" : $this->acc['EMail'];
            $_SESSION['R'] = $this->acc['Right'];
            $_SESSION['SP'] = (empty($this->acc['SkyPoints'])) ? 0 : $this->acc['SkyPoints'];
            array_push($err,2);
        }
        return $err;
    }

}
