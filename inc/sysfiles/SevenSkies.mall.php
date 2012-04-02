<?php
/**
 * Description of SevenSkies
 *
 * @author Nifix
 */

namespace SevenSkies;

class Mall {
    
    private $utils = null;
    private $cp = null;
    private $types = array(1=>"Misc",2=>"Scrolls",3=>"Back Item",4=>"Costume");
    private $lifetime = array(0=>"None",1=>"1 Day",2=>"3 Days",3=>"7 Days",
                              4=>"1 Hour",5=>"5 Hours",6=>"Permanent");
    
    function __construct()
    {
        $this->utils = new Utils();
        $this->cp = new ControlPanel($this->utils->sStrip($_SESSION["UID"]));
    }
    
    public function printCatalog($idx,$cat)
    {
        if (!array_key_exists($cat,$this->types)) return "No items in this category.";
        $output = '<div align="center" class="fpage">';
        $output .= '<a href="catalog-1-1.ss">Misc Items</a> | <a href="catalog-2-1.ss">Scrolls</a> | <a href="catalog-3-1.ss">Back Items</a> | <a href="catalog-4-1.ss">Costumes</a><br /><br />';
        $data = $this->utils->sQuery('SELECT * FROM ss_ditems WHERE type = ?',array($cat),false,true);
        $nbitems = count($data);
        $nbpages = ceil($nbitems / Conf::MALL_ITEM_PER_PAGE);
        $fItem = ($idx-1) * Conf::MALL_ITEM_PER_PAGE;
        for ($j=1; $j <= $nbpages; $j++)
        {
            if ($nbpages != 1) {
                if ($j == 1) {
                    if ($j != $idx)
                        $output .= ' <a href="catalog-'.$cat.'-'.$j.'.ss">'.$j.'</a> ';
                    else $output .= ' '.$j.' ';
                } else if ($j == $nbpages)
                {
                    if ($j != $idx)
                        $output .= ' | <a href="catalog-'.$cat.'-'.$j.'.ss">'.$j.'</a>';
                    else $output .= ' | '.$j.' ';                
                } else {
                    if ($j != $idx)
                        $output .= ' | <a href="catalog-'.$cat.'-'.$j.'.ss">'.$j.'</a> ';
                    else $output .= ' | '.$j.' ';                
                }
            } else {
                $output .= '';
            }
        }
        $output .= '</div>';
        $max = Conf::MALL_ITEM_PER_PAGE;
        $data = $this->utils->sQuery("SELECT * FROM ss_ditems WHERE type = ? LIMIT $fItem, $max",array($cat),false,true);
        for ($i=0; $i<count($data); $i++)
        {
            $isPack = ($data[$i]["inpack"] == 1) ? "Part of a pack" : "Not part of a pack";
            $isBuyable = ($data[$i]["cost"] <= $_SESSION["SP"]) ? '<a href="catalogbuy-'.$data[$i]["catid"].'-'.$data[$i]["itemid"].'.ss">Buy this item !</a>' : '<font color=red>Sorry, you can\'t afford that.</font>';
            $output .= '
                <table><caption>'.$data[$i]["desc"].'</caption>
                    <tbody>
                       <tr><td rowspan="3"><img src="images/icons/ICON18_Number-'.$data[$i]["icon"].'.png" /></td>
                       <td width="150" colspan="2"><b>Lifetime :</b> '.$this->lifetime[$data[$i]["length"]].'</td>
                       <td width="90" colspan="2"><b>Type :</b> '.$this->types[$data[$i]["type"]].'</td>
                       <td colspan="2"><b>Quantity :</b> '.$data[$i]["quantity"].'</td><td colspan="2" width="80">'.$isPack.'</td></tr>
                       <tr><td colspan="3"><b>Cost :</b> '.$data[$i]["cost"].' Sky Points</td><td colspan="5">'.$isBuyable.'</td></tr>
                       <tr><td colspan="8"><b>Description :</b> '.$data[$i]["desc"].'</td></tr>
                    </tbody>
                </table><br />';
        }
        return $output;
    }
    
    private function securityCheck($type,$id)
    {
        $data = $this->utils->sQuery("SELECT * FROM ss_ditems WHERE catid=$type AND itemid=$id");
        return (empty($data)) ? false : $data;
    }
    
    public function checkItem($type,$id)
    {
        $data = $this->securityCheck($this->utils->sStrip($type), $this->utils->sStrip($id));
        if (!empty($data)) {
            $nbalance = $_SESSION["SP"] - $data[0]["cost"];
            $output = "You're trying to buy this item :<br /><br />";
            $output .= "<form method=\"POST\" name=\"confirmb\">";
            $output .= "<input type=\"hidden\" name=\"confirmb\" />";
            $output .= "<table><tr><td colspan=\"2\"><div align=\"center\"><img src=\"images/icons/ICON18_Number-".$data[0]["icon"].".png\" /></div></td></tr>";
            $output .= "<tr><td>Description :</td><td>".$data[0]["desc"]."</td></tr>";
            $output .= "<tr><td>Quantity :</td><td>".$data[0]["quantity"]."</td></tr>";
            $output .= "<tr><td>Your current balance :</td><td>".$_SESSION["SP"]." Sky Points</td></tr>";
            $output .= "<tr><td>Price :</td><td><b>- ".$data[0]["cost"]." Sky Points</b></td></tr>";
            $output .= "<tr><td>New Balance :</td><td><font color=\"red\">".$nbalance."</font> Sky Points</td></tr>";
            $output .= "<tr><td colspan=\"2\"><div align=\"center\"><a id=\"confirmpurchase\">I confirm ! I wanna buy it !</a></div></td></tr>";
            $output .= "</table></form>";
            echo $output;
        } else {
            echo "No.";
        }
    }
    
    public function buyItem($type,$id)
    {
        $type = $this->utils->sStrip($type);
        $id = $this->utils->sStrip($id);
        $data = $this->securityCheck($type, $id);
        $acc = $_SESSION["UID"];
        $curdata = $this->utils->sQuery("SELECT * FROM i7skies_core..UserInfo WHERE Account = ?",array($acc),false,false);
        $newb = $_SESSION["SP"] - $data[0]["cost"];
        if (empty($curdata)) return false;
        else if ($_SESSION['SP'] != $curdata[0]["SkyPoints"]) return false;
        else if ($newb < 0) return false;
        else {
            $output = "<h2>Congratulations !</h2><br /><br />Bought item : ".$data[0]["desc"]." successfully.<br /><br />It should already appear in the \"Item Mall\" storage. Also <b>".$data[0]["cost"]."</b> SkyPoints
                were removed from your account balance.<br /><br /><a href=\"catalog-1-1.ss\">Click here to go back to the Item Mall index</a>";
            $_SESSION["SP"] = $newb;
            $this->utils->sQuery("UPDATE i7skies_core..UserInfo SET SkyPoints = $newb WHERE Account = ?",array($acc),false,false);
            try {
                $conn = new \PDO("sqlsrv:Server=".Conf::MS_HOST.";Database=i7skies_mall",Conf::MS_LOGIN,Conf::MS_PWD);
                $conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("{:retval= CALL InsertITEM(:acc,:itemtype,:itemid,:itemcount)};");

                $retval = null;

                $stmt->bindParam(":retval", $retval, \PDO::PARAM_STR, 4);
                $stmt->bindParam(":acc", $_SESSION['UID']);
                $stmt->bindParam(":itemtype", $type);
                $stmt->bindParam(":itemid", $id);
                $stmt->bindParam(":itemcount", $data[0]["quantity"]);

                $stmt->execute();
                $stmt->closeCursor();
            } catch (PDOException $e) {
                echo "SevenSkies Database Error : ".$e->getMessage()."\n";
                exit;
            }
        }
        return $output;
    }
   
}

?>
