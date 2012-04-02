<?php

/**
 * Sky Points functions actually. =l
 *
 * @author Nifix
 */

namespace SevenSkies;

class SkyPoints {

	private $utils = null;

	/**
	* Prints the first form, with options about the amount of points.
	*
	* @return string $output HTML Block of text
	*/
	
	public function printForm()
	{
		$output = '<h3>Buying Points !</h3>We have several options for you to buy points, for now they\'re all for paypal only, you 
		can choose one of them, you\'ll need to checkout your order and then you\'ll be redirected to paypal to initiate your payment.<br /><br />The currency applied here is the USD dollar.<br /><br />';

		$output .= '<form method="post">';
		$output .= '<div id="paypalopts">'; 
		$output .= '<input type="radio" id="opt1" name="amount" value="5.00" /><label for="opt1">500 Points for 5$ USD</label>';
		$output .= '<input type="radio" id="opt2" name="amount" value="9.00" /><label for="opt2">1000 Points for 9$ USD</label>';
		$output .= '<input type="radio" id="opt3" name="amount" value="13.00" /><label for="opt3">1500 Points for 13$ USD</label>';
		$output .= '</div>';

		$output .= '<br /><br /><input id="checkout" type="submit" value="Proceed to Checkout !" /></form>';

		return $output;

	}

	public function printCheckout($amount)
	{

		$this->utils = new \SevenSkies\Utils();
		$amount = $this->utils->sStrip($amount);
		$item = "";
		if ($amount == "5.00") $item = "500 Sky Points";
		else if ($amount == "9.00") $item = "1000 Sky Points";
		else if ($amount == "13.00") $item = "1500 Sky Points";
		else { $item = "n/a"; }

		$output = '<h3>Buying Points - Checkout !</h3>';


		$output .= '<table><tr><td><b>Item chosen :</b></td><td>'.$item.'</td></tr>';
		$output .= '<tr><td><b>Price :</b></td><td>$'.$amount.' USD</td></tr>';
		$output .= '</table>';
		$output .= '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
		$output .=		'<input type="hidden" name="amount" value="'.$amount.'" />';
		$output .=		'<input name="currency_code" type="hidden" value="USD" />';
		$output .=		'<input name="shipping" type="hidden" value="0.00" />';
		$output .=		'<input name="tax" type="hidden" value="0.00" />';
		$output .=		'<input name="return" type="hidden" value="http://direct.sevenskiesonline.com:1337/success.ss" />';
		$output .=		'<input name="cancel_return" type="hidden" value="http://direct.sevenskiesonline.com:1337/cancel.ss" />';
		$output .=		'<input name="notify_url" type="hidden" value="http://direct.sevenskiesonline.com/notify.ss" />';
		$output .=		'<input name="cmd" type="hidden" value="_xclick" />';
		$output .=		'<input name="item_number" type="hidden" value="0" />';
		$output .=		'<input name="item_name" type="hidden" value="Sky Points" />';
		$output .=		'<input name="no_note" type="hidden" value="1" />';
		$output .=		'<input name="lc" type="hidden" value="US" />';
		$output .=		'<input name="rm" type="hidden" value="2" />';
		$output .=		'<input name="business" type="hidden" value="'.Conf::EMAIL_PAYPAL.'" />';
		$output .=		'<input type="hidden" name="bn" value="PP-BuyNowBF">';
		$output .=		'<input name="custom" type="hidden" value="'.$_SESSION['UID'].'" />';
		$output .=		'<br /><br /><input type="submit" value="Proceed to payment !" />';
		return $output;
	}
}

?>