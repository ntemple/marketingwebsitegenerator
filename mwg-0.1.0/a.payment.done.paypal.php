<?php
/**
 * @version    $Id: $
 * @package    MWG
 * @copyright  Copyright (C) 2010 Intellispire, LLC. All rights reserved.
 * @license    GNU/GPL v2.0, see LICENSE.txt
 *
 * Marketing Website Generator is free software. 
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

 
include ("vars.inc.php");
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}
// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$txn_type = $_POST['txn_type'];
$custom = $_POST['custom'];
$id=$custom;
$q=new Cdb;
$query="select * from members where id='$id'";
$q->query($query);
$q->next_record();
$custom=$q->f("aff");
if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
	// check the payment_status is Completed
	if ($txn_id!=get_setting("txn_id"))
	{
		save_setting("txn_id", $txn_id);
		
		if ($payment_status=="Completed")
		{
			include ("a.aff.inc.php");
			//credit affiliates
			process_sale($payment_amount, $custom ,$payer_email);
			//execute signup procedure
			$q=new Cdb();
			
			if ($txn_type=="subscr_signup" || $txn_type=="subscr_payment")
			{
				
				$query="update members set paid='5' where id='$id'";
				$q->query($query);
				
			}
				
			if ($item_number=="LDC29")
			{
				mail($payer_email, "Thanks for purchase", "Your link is:\n http://www.letsallworkathome.com/plistarpplat.html", "From: $sitename <$webmasteremail>");
			}			
			$query="update members set paid_bde=1 where id='$id'";
			$q->query($query);
			
		}
	}
	else
	{
		save_setting("txn_id", $txn_id);
	}
	// check that txn_id has not been previously processed
	// check that receiver_email is your Primary PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment
}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
}
}
fclose ($fp);
}
?>
