<?php
/**
*
* Some hexadecimal functions for the SevenSkies Control Panel.
*
* @author Nifix 
*
*/
namespace SevenSkies;

class HexFuncs
{
    /**
    *
    * getByte()
    *
    * @return integer
    *
    */

    public function getByte($hex,$idx)
    {
        $tmp = substr($hex,$idx,2); 
        return hexdec($tmp);
    }
    
    /**
    *
    * getWord()
    *
    * @return integer
    *
    */
    
    public function getWord($hex,$idx)
    {
        $tmp = substr($hex,$idx,4); 
		$tmp = hexdec($tmp);
        return (($tmp & 0xff00) >> 8) ^ (($tmp & 0x00ff) << 8);
    }
    
    /**
    *
    * getDWord()
    *
    * @return integer
    *
    */

    public function getDWord($hex,$idx)
    {
        $tmp = substr($hex,$idx,8);
        $tmp = hexdec($tmp); 
		return (($tmp & 0xff000000) >> 24) ^ (($tmp & 0x00ff0000) >> 8) ^ (($tmp & 0x0000ff00) << 8) ^ (($tmp & 0x000000ff) << 24);
    }
	
    /**
    *
    * getCoord()
    *
    * @return float
    *
    */

	public function getCoord($hex)
	{
		$bin = str_pad(base_convert($hex, 10, 2), 32, "0", STR_PAD_LEFT); 
		$sign = $bin[0]; 
		$exp = bindec(substr($bin, 1, 8)) - 127; 
		$man = (2 << 22) + bindec(substr($bin, 9, 23)); 
		$dec = $man * pow(2, $exp - 23) * ($sign ? -1 : 1); 
		$dec = round($dec*pow(10,-2),2);
		return $dec;
	}
}
?>
