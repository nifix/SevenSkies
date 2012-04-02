<?php

/**
 * Ranking class, will manage everything related
 * to the rankings on SevenSkies website.
 *
 * @author Nifix
 */

namespace SevenSkies;

class Ranking {
    
    private $utils = null;
    private $data = array();
    
    function __construct()
    {
        $this->utils = new \SevenSkies\Utils();
    }
    
    private function gatherData($type)
    {
        
        $limit = Conf::RANK_LIMIT;
        
        switch ($type)
        {
            case 0:
                $this->data = $this->utils->sQuery("SELECT TOP $limit * FROM i7skies..tblGS_AVATAR WHERE ((dwRIGHT < 3) OR (dwRIGHT = 16)) ORDER BY btLEVEL DESC",array(),false,false);
                break;
            case 1:
                $this->data = $this->utils->sQuery("SELECT TOP $limit * FROM i7skies..tblGS_AVATAR WHERE (dwRIGHT < 3) ORDER BY intPVPWins DESC",array(),false,false);
                break;
            case 2:
                $this->data = $this->utils->sQuery("SELECT TOP $limit * FROM i7skies..tblGS_AVATAR WHERE (dwRIGHT < 3) ORDER BY intPVPLoses DESC",array(),false,false);
                break;
            case 3:
                $this->data = $this->utils->sQuery("SELECT TOP $limit * FROM i7skies..tblGS_AVATAR WHERE (dwRIGHT < 3) ORDER BY intPKCount DESC",array(),false,false);
                break;
            case 4:
                $this->data = $this->utils->sQuery("SELECT TOP $limit * FROM i7skies..tblGS_AVATAR WHERE (dwRIGHT < 3) ORDER BY intKarmaPoints DESC",array(),false,false);
                break;
            case 5:
                $this->data = $this->utils->sQuery("SELECT TOP $limit * FROM i7skies..tblGS_AVATAR WHERE (dwRIGHT < 3) ORDER BY txtNAME ASC",array(),false,false);
                break;
        }
        return $this->data;  
    }
    
    private function getType($id)
    {
        $types = array("0"=>"level","1"=>"PvP wins","2"=>"PvP loses","3"=>"PKs","4"=>"karma","5"=>"nickname");
        return $types[$id];
    }
    public function showRank($type,$context)
    {
        $rank = 1;
        $output = $this->getTable($type, $context);
        $data = $this->gatherData($type);
        for ($i=0; $rank<=20; $i++) {
			if (!$this->toIgnore($data[$i]["txtACCOUNT"])) { 
			    if (substr($data[$i]["txtNAME"],0,1) != "[") {
					if ($context == 0) {
						$output .= '<tr><td>#'.$rank.'</td><td>'.$data[$i]["txtNAME"].'</td><td>'.$this->utils->getJob($data[$i]["intJOB"]).'</td><td>'.$data[$i]["btLEVEL"].'</td>';
					} else if ($context == 1)
					{
						$output .= '<tr><td>#'.$rank.'</td><td>'.$data[$i]["txtNAME"].'</td><td>'.$this->utils->getJob($data[$i]["intJOB"]).'</td>';
						$output .= '<td>'.$data[$i]["intPVPWins"].'</td><td>'.$data[$i]["intPVPLoses"].'</td><td>'.$data[$i]["intPKCount"].'</td>';
						$output .= '<td>'.$data[$i]["intKarmaPoints"].'</td></tr>';
					}
					$rank++;	
				} else if ($this->whiteList($data[$i]["txtNAME"])) {
					if ($context == 0) {
						$output .= '<tr><td>#'.$rank.'</td><td>'.$data[$i]["txtNAME"].'</td><td>'.$this->utils->getJob($data[$i]["intJOB"]).'</td><td>'.$data[$i]["btLEVEL"].'</td>';
					} else if ($context == 1)
					{
						$output .= '<tr><td>#'.$rank.'</td><td>'.$data[$i]["txtNAME"].'</td><td>'.$this->utils->getJob($data[$i]["intJOB"]).'</td>';
						$output .= '<td>'.$data[$i]["intPVPWins"].'</td><td>'.$data[$i]["intPVPLoses"].'</td><td>'.$data[$i]["intPKCount"].'</td>';
						$output .= '<td>'.$data[$i]["intKarmaPoints"].'</td></tr>';
					}
					$rank++;
				}
			}
		}
        $output .= '</tbody></table>';
        return $output;
	}
    
    private function toIgnore($acc)
    {
        $accs = array("IKOLA","xndaleet","N1ghtmare","icon","landrel","newzaar","prime112486","noxi","D3v1lT00n","tgn1234");
        if (in_array($acc,$accs)) return true;
        else return false;
    }
	
	private function whiteList($ch)
	{
		$chs = array("[GS]Skittles","[GS]Tichinde925");
		if (in_array($ch,$chs)) return true;
		else return false;
	}
    
    private function getTable($type,$context)
    {
        if ($context == 0)
        {
            $output = '<table><caption>Ranking Informations by '.$this->getType($type).'</caption>';
            $output .= '<thead><tr><th scope="col">Rank</th><th scope="col" width="100">Nickname</th><th scope="col">Job</th>';
            $output .= '<th scope="col"><a href="ranking-0.ss">Level</a></th></thead><tbody>';
        } else if ($context == 1)
        {
            $output = '<table><caption>PvP Ranking Informations by '.$this->getType($type).'</caption>';
            $output .= '<thead><tr><th scope="col">Rank</th><th scope="col">Nickname</th><th scope="col">Job</th>';
            $output .= '<th scope="col"><a href="rankingpvp-1.ss">PvP Wins</a></th>';
            $output .= '<th scope="col"><a href="rankingpvp-2.ss">PvP Loses</a></th>';
            $output .= '<th scope="col"><a href="rankingpvp-3.ss">PKs</a></th><th scope="col"><a href="rankingpvp-4.ss">Karma</a></th></thead><tbody>';
        }
        return $output;
    }
    
    
}

?>
