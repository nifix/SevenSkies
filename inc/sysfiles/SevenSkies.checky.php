<?php
/**
 * Server Checker SevenSkies
 *
 * @author Nifix
 * @package SevenSkies\Checky
 */
namespace SevenSkies;

class Checky 
{
    
    /** 
    * @var mixed xml file handle
    */

    private $x = null;
    
    /**
    * Grabbing Xml from the file.
    *
    * @return string xml file.
    * Testing ftw #5
    */

    private function getXml()
    {
        if (empty($this->x))
            $this->x = simplexml_load_file(Conf::XML_SERVERS);
        return $this->x;
    }
    
    /**
    * Grabbing current servers status, updating if necessary.
    *
    * @return string xml data, updated or not.
    */

    private function getCurrent()
    {
        $this->isOutdated();
        $x = $this->getXml();
        $r = array();
        foreach ($x as $s)
            array_push($r,$s[0]);
        return $r;
    }
    
    /**
    *
    * Checks if the values from the file are outdated.
    *
    * @return void
    *
    */

    private function isOutdated()
    {
        $c = $this->getXml();
        $c = $c->LastUpdate;
        $d = time();
        $dc = $d-$c;
        if ($dc > Conf::CHECKY_T) $this->goUpdate();
    }
    
    /**
    *
    * Grabbing current servers status, updating if necessary.
    *
    * @return string xml data, updated or not.
    *
    */

    private function goUpdate()
    {
        $r = array();
        $x = $this->getXml();
        $i = 0;
        $a = explode(";",Conf::SERVER_IPS);
        foreach ($a as $cip)
        {
            $sip = explode(":",$cip);
            $l = @fsockopen($sip[0], $sip[1], $errno, $errstr, 10);
            if ($l) {
                array_push($r,1);
                @fclose($l);
            } else { array_push($r,0); }  
        }
        array_push($r,time());
        $s = '<SevenSkies xmlns="http://sevenskiesonline.com/inc/SevenSkies" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://sevenskiesonline.com/inc/SevenSkies http://sevenskiesonline.com/inc/ServStatus.xsd"><Login>'.$r[0].'</Login><Char>'.$r[1].'</Char><World>'.$r[2].'</World><LastUpdate>'.$r[3].'</LastUpdate></SevenSkies>';
        $s = simplexml_load_string($s); 
        $s->asXML(Conf::XML_SERVERS);
    }

    /**
    *
    * Print the status on the main page.
    *
    * @return string HTML with pictures depending on the status.
    *
    */
    
    public function toggleStatus()
    {
        $i = 0;
        $op = "";
        $s = array("L","C","W");
        $r = $this->getCurrent();
        foreach($r as $p)
        {
            if ($i <= 2) {                          
                $re = ($p == 1) ? "Up" : "Down";
                $op .= '<img src="./images/'.$s[$i].$re.'.png" /><br />';
                $i++;
            }  
        }
        $d = date("Y-m-d H:i",(int)$r[3]);
        $op .= "<br />Latest update<br />".$d;   
        return $op;
    }
    
}

?>
