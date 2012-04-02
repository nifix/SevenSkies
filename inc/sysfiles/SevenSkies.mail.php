<?php

/**
* @copyright SevenSkies -  TGN Studios
* @author Nifix
* @name SevenSkies.mail.php
* @namespace SevenSkies
*/

namespace SevenSkies;

class Mailer {
    
    
    private $sServer = "smtpout.secureserver.net";
    private $sPort = "3535";
    private $sTimeout = "30";
    private $sUid = "accounts@sevenskiesonline.com";
    private $sPwd = "sammae";
    private $sLoc = "127.0.0.1";
    private $sRn = "\r\n";
    private $sLink = null;
    private $isSecure = true;
    private $sLogs = array();
    
    /**
    * Sends a mail.
    *
    * @param string $sFrom From who.
    * @param string $snFrom From who again, but actual name.
    * @param string $sTo To who.
    * @param string $snTo To who again, but actual name.
    * @param string $sObj Subject of the mail.
    * @param string $sMsg Body.
    * @return string $Output Form to display.
    */
    public function SendMail($sFrom,$snFrom,$sTo,$snTo,$sObj,$sMsg)
    {
        $this->sLink = fsockopen($this->sServer,$this->sPort,$sErrno,$sErrstr,$this->sTimeout);
        if (empty($this->sLink)) return 0;
        $this->sendCmd("HELO ".$this->sLoc);
        if ($this->isSecure) $this->startDialog();
        $this->sendCmd("AUTH LOGIN");
        $this->sendCmd(\base64_encode($this->sUid));
        $this->sendCmd(\base64_encode($this->sPwd));
        $this->sendCmd("MAIL FROM: ".$sFrom);
        $this->sendCmd("RCPT TO: ".$sTo);
        $this->sendCmd("DATA");
        $this->sendCmd("To: ".$sTo."\r\nFrom: ".$sFrom."\r\nSubject: ".$sObj."\r\n".($this->buildHeaders($snTo,$sTo,$snFrom,$sFrom))."\r\n\r\n".$sMsg."\r\n.\r\n");
        $this->sendCmd("QUIT");
        fclose($this->sLink);
    }
    
    /**
     * Adds \r\n at the end.
     * 
     * @param string $sString
     * @return string 
     */
    private function formatText($sString)
    {
        return $sString.$this->sRn;
    }
    
    /**
     * Creates the headers of the mail.
     * 
     * @param string $snTo
     * @param string $sTo
     * @param string $snFrom
     * @param string $sFrom
     * @return string
     */
    private function buildHeaders($snTo,$sTo,$snFrom,$sFrom)
    {
        $Output = $this->formatText("MIME-Version: 1.0");
        $Output .= $this->formatText("Content-type: text/html; charset=iso-8859-1");
        $Output .= $this->formatText("To: ".$snTo." <".$sTo.">");
        $Output .= $this->formatText("From: ".$snFrom." <".$sFrom.">");
        return $Output;
    }
    
    /**
     * Sends a command to the server, and grabs a reply, and log it to global array.
     * 
     * @param string $sString
     * @param string $sMode S by default for simple mode, TLS otherwise.
     * @return string 
     */
    private function sendCmd($sString,$sMode = "S")
    {
        fputs($this->sLink,$this->formatText($sString));
        array_push($this->sLogs,array("[SEND ".$sMode."] "=> $sString));
        $sReply = fgets($this->sLink,4096);
        array_push($this->sLogs,array("[RECV ".$sMode."] "=>$sReply));
        return $sReply;
    }
    
    /**
     * Just sends two CMDs to use TLS Connection.
     * 
     * @return void 
     */
    private function startDialog()
    {
        $this->sendCmd("STARTTLS","TLS");
        $this->sendCmd("HELO ".$this->sLoc,"TLS");
    }
}

?>