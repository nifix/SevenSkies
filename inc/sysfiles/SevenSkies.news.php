<?php

/*
 * 
 * SevenSkies - News class handler
 * 
 * 
 */

namespace SevenSkies;
require_once("SevenSkies.utils.php");

class News 
{
    
    private $utils;
	
    function __construct()
    {
	$this->utils = new Utils();
    }
    
    private function addNews($title,$content,$author,$icon = 0)
    {
        $tnow = time();
        $varr = array("",$tnow,$title,$text,$author,$icon);
        $this->utils->sQuery('INSERT INTO ss_news VALUES(?,?,?,?,?,?)',$varr,true,true);
        return 1;
    }
    
    protected function getNews()
    {
	    return $this->utils->sQuery('SELECT * FROM ss_news ORDER BY t DESC LIMIT 0,8');
    }
    
    public function printNews()
    {
	
        $dNews = $this->getNews();
        $op = "";
        for ($i=0;$i<count($dNews);$i++)
        {
            $ts = date("m-d-y, H:i",$dNews[$i][1]);
            switch ($dNews[$i][5]) {
            case 0: $icon = "announce.png";
            break;
            case 1: $icon = "notice.png";
            break;
            case 2: $icon = "event.png";
            break;
            }
            $op .= '<div><h3><a href="#"><img src="./images/'.$icon.'" /><span style="color:black; size:*px;">&nbsp;'.$dNews[$i][2].'</span>&nbsp; <div style="float:right;">(<b>'.$dNews[$i][4].'</b> / '.$ts.')</div></a></h3><div>'.nl2br($dNews[$i][3]).'</div></div>';

        }
        return $op;
    }
}

?>