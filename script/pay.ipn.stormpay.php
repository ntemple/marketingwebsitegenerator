<?php
/**
 * @version    $Id$
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

 //version 1.5 
	function rnd5() {
	return strtoupper(substr(md5(microtime() . rand(1, 1000000)), 0, 5));
	}
	$_Vars = (strtoupper($REQUEST_METHOD) == "POST") ? $_POST : $_GET;
	$status = trim($_Vars[status]);                 
	$transaction_id = $_Vars[transaction_id];           																		
	$subscription_id = $_Vars[subscription_id];         
	$program_id = $_Vars[program_id];                   
	$transaction_ref = trim($_Vars[transaction_ref]);   
	$subscription_ref = $_Vars[subscription_ref];       
	$transaction_date = $_Vars[transaction_date];       // the Date/Time of the transaction (timestamp) - in the case of a cancelled subscription, this will simply be the date/time of the cancellation
	$cancel_date = $_Vars[cancel_date];                 // IF a subscription was CANCELLED then you will get a "cancel_date" - in date/time format
	$refund_date = $_Vars[refund_date];                 // IF this is a REFUND then you will get a "refund_date" - in date/time format
	$chargeback_date = $_Vars[chargeback_date];         // IF this is a CHARGEBACK then you will get a "chargeback_date" - in date/time format
	$secret_code = $_Vars[secret_code];                 // BLANK if you did NOT set your SECRETE CODE in the "Profile / Setup" at the "IPN Configuration" section
	$vendor_id = (integer)$_Vars[vendor_id];            // if sent in a Button Link Codes
	$vendor_email = $_Vars[vendor_email];               // if sent in a button link code
	$associates = $_Vars[associates];                   // if sent in a button link code (see Integration Manual for details)
	$credit = (float)$_Vars[credit];                    // The TOTAL (GROSS) amount PAID to you (INCLUDING any Tax and/or Shipping sent in your Link Codes, as the case may be)
	$amount = (float)$_Vars[amount];                    // SAME value as the credit
	$donation = (float)$_Vars[donation];                // SAME value as the credit - the TOTAL (GROSS) amount PAID to you as a DONATION(for charity, gifting, etc)
	$transaction_type = $_Vars[transaction_type];  
 	$transaction_fee = (float)$_Vars[transaction_fee];  
	$unit_price = (float)$_Vars[unit_price];            // IF a unit price is sent in the button Link code OR if the transaction was form an "Open Amount" or "Donation" Buy Button
	$quantity = trim($_Vars[quantity]);                
	$tax = (float)$_Vars[tax];                          // IF sent in the buy button Link Code, or if user add it in the "open_amount" request
	$s_and_h = (float)$_Vars[s_and_h];                  // IF sent in the buy button Link Code, or if user add it in the "open_amount" request
	$shipping = (float)$_Vars[shipping];                // SAME as the "s_and_h" variable. Handled exactly like the "s_and_h" variable and BOTH are sent back with the SAME value
	$user_id = $_Vars[user_id];                         // IF sent in the buy button Link Code (is also APPENDED to the END of the "return_URL" value IF the "return_URL" was supplied)
 	$payee_email = $_Vars[payee_email];                 // ALWAYS present - the person RECEIVING the payment, OR in the case of a CANCEL or CHARGEBACK the person who was the original payee
	$payer_email = $_Vars[payer_email];                 // ALWAYS present - the person SENDING the payment, OR in the case of a CANCEL or CHARGEBACK the person who was the original payer (payor)
	$payer_name = $_Vars[payer_name];                   // ALWAYS present - the NAME of person SENDING the payment in the format - "name or business name (payer@somedomain.com)"
	$category = $_Vars[category];                       // will be BLANK or = "Miscellaneous" IF a recognised "category" was NOT sent in your Link Code
	
	$product_name = $_Vars[product_name];                // the "product_name" is sent IF only a SINGLE item (even for shopping Cart transaction with just 1 item)
	$entity = $_Vars[entity];                            // the name of an ENTITY like your Church, or Charity Organization that received the DONATION and the "product_name" will contain the SAME value
	$person = $_Vars[person];                            // the name of a PERSON like your Friend or Family menber that received the DONATION and the "product_name" will contain the SAME value
	$user1 = $_Vars[user1];                             // Sent back to you IF sent in your Link Codes for ALL INITIAL payments, OTHERWISE this variable is NOT available
	$user2 = $_Vars[user2];                             // Sent back to you IF sent in your Link Codes for ALL INITIAL payments, OTHERWISE this variable is NOT available
	$user3 = $_Vars[user3];                             // Sent back to you IF sent in your Link Codes for ALL INITIAL payments, OTHERWISE this variable is NOT available
	$user4 = $_Vars[user4];                             // Sent back to you IF sent in your Link Codes for ALL INITIAL payments, OTHERWISE this variable is NOT available
	$user5 = $_Vars[user5];                             // Sent back to you IF sent in your Link Codes for ALL INITIAL payments, OTHERWISE this variable is NOT available
	$note = $_Vars[note];                               // Sent back to you IF sent in your Button Link Codes or entered by Customer at the StormPay Pay form, OTHERWISE this variable is NOT available  - this field is NEVER forced except if sent in button link
//	
require_once("inc.top.php");
require_once("lib/inc.payment.functions.php");
$payment_status     = "Completed";
$payment_amount     = $amount;
$custom             = $user2;
$query="select * from session where session_id='$custom'";
$q->query($query);
$q->next_record();
$s_product_id  = $q->f("product_id");
$s_member_id   = $q->f("member_id");
if ($s_member_id==0)
{
	if ($q->f("affiliate_id")!=0)
	{
		$aff_flag=1;
		$s_member_id=$q->f("affiliate_id");
	}
	else $aff_flag=0;
}
else $aff_flag=0;
$s_session     = $q->f("session_id");
$s_paid        = $q->f("paid");
if ($txn_id == get_setting('txt_id') ) {
  die();
}
//echo "p_id: $s_product_id, member_id: $s_member_id, sess: $s_session, paid: $s_paid <br>";
set_setting("txn_id", $txn_id);
		
		if ($payment_status=="Completed")
		{
			//credit affiliates
			process_sale($payment_amount, $s_member_id ,$s_product_id, $aff_flag);
		
			if ($s_paid==1) 
			{
				$paid2=1;
				$paid=1;
			}
			else
			{
				$paid=1;
				$paid2=0;
			}
			$query="update session set paid=$paid, paid_step2=$paid2 where session_id='$s_session'";
			$q->query($query);
			
			$query="select * from products where id='$s_product_id'";
			$q->query($query);
			$q->next_record();
			
			$membership_id=$q->f("membership_id");
			
			$query="update members set membership_id='$membership_id' where id='$s_member_id'";
			$q->query($query);
			updateHistory($s_member_id, $membership_id, true);
			 
		}
			 
	//
	$retry_id = (int)$_Vars[retry_id];                  // This is a UNIQUE ID set on IPN DATA for retry POST (this is NOT a transaction id).
                                                        // You ALREADY have the "transaction_id" which you can use
                                                        // to PREVENT duplication (on SUCCESS, REFUND and CHARGEBACK).
                                                        // However, in the event that you did previously received and
                                                        // processed a particular set of IPN data, but StormPay did not
                                                        // get a "proper" HTTP/1.1 202 reply from you, and continue to
                                                        // POST to your server-side script, the existence of the "retry_id"
                                                        // (and he "retry_count" below) would also let you know that
                                                        // StormPay had made at least 1 previous attempt to post
                                                        // the SAME set of IPN data to your server-side script.
                                                        // So especially in the case of a CANCEL (or ERROR) post, which
                                                        // may not have a transaction_id for you to check for duplicates,
                                                        // you can use the "retry_id" to know if you already received that
                                                        // SAME set of IPN data.
                                                        // Again, the "retry_id" is NOT the transaction id. Is is ONLY
                                                        // a UNIQUE identifier on a particular set of IPN data set for
                                                        // RE-TRY POSTing of the IPN data to your script. Set because of
                                                        // previous failed POST attempt OR lack of a "proper" HTTP/1.1 202
                                                        // reply from your script on previous POSTing.
	$retry_count = (int)$_Vars[retry_count];        // The amount of RE-TRIES on HTTP POST on the SAME set of IPN
                                                        // data sent to your server-side (IPN) processor.
                                                        // IPN will be POSTed (retried) a MAXIMUM 5 times (if necessary)
	// the values retrieved above this line can be stored to a DATABASE from this point on
	// prepare a message to send OUT a simple feedback e-mail (just for TEST purposes and with NO special logic or format, but with a few changes this can be part of a REAL production process)
	$msg = "StormPay IPN TEST - Details.";
	$msg .= "\n";
        $msg .= "Status = " . $status;
        $msg .= "\n";
        $msg .= "transaction ID = ". $transaction_id;
        $msg .= "\n";
        $msg .= "subscription ID = ". $subscription_id;  // this is the SAME as the Program ID ($program_id) it is a UNIQUE # for your (subscription) PROGRAM
        $msg .= "\n";
        $msg .= "Program ID = ". $subscription_id;       // this is the SAME as above ($subscription_id) it is a UNIQUE # for your (subscription) PROGRAM
        $msg .= "\n";
        $msg .= "subscription Ref = ". $subscription_ref; // PLEASE NOTE: again this is the UNIQUE SUBSCRIPTION REFERENCE # for the particular Subscription REGISTRATION of a Subscriber
                                                    // this is the value you must use to UNIQUELY reference a particular Subscription payment
	$msg .= "\n";
	$msg .= "Transaction Ref = " . $transaction_ref;
	$msg .= "\n";
	$msg .= "Secret Code = " . $secret_code;
	$msg .= "\n";
	$msg .= "Transaction Date = " . $transaction_date;
	$msg .= "\n";
	$msg .= "Total Credit amount = " . $credit;         // this will carry any (GROSS) credit to the "payee_email" for ALL IPN posts (GROSS means - any applicable transaction fee is NOT (yet) removed form that value)
	$msg .= "\n";
	$msg .= "Transaction Fee ? = " . $transaction_fee;  // IF applicable - this will carry the fees charged for the transaction
	$msg .= "\n";
	$msg .= "Tax  = " . $tax;
	$msg .= "\n";
	$msg .= "Shipping/Handling = " . $s_and_h;
	if($distinct_item_count <= 0){                      // meaning IF the transaction was NOT treated like a Shopping cart transaction
	  $msg .= "\n";
	  $msg .= "Unit Price = " . $unit_price;
	  $msg .= "\n";
	  $msg .= "Quantity = " . $quantity;
	  $msg .= "\n";
	  $msg .= "Product Name = " . $product_name;
	  $msg .= "\n";
	  $msg .= "Category = " . $category;
	}
	else{                                              // ELSE, IF the transaction WAS treated like a Shopping cart transaction
	  for($i = 0; $i < count($item_info); $i++){
	    $msg .= "\n";
	    $msg .= "Item Info".($i+1)." = " . $item_info[$i];
	  }
	}
	$msg .= "\n";
	$msg .= "Items List = " . $_Vars[items_list];  // OR you can simply get a list of ALL the Items - in this case we take the "raw" list rather than the array ($items_list) just for demonstration
	$msg .= "\n";
	$msg .= "Entity or Person receiving DONATION = " . $entity;  // IF this was a POST on a Donation (payment)
	$msg .= "\n";
	$msg .= "vendor ID " . $vendor_id;
	$msg .= "\n";
	$msg .= "Vendor Email = " . $vendor_email;
	$msg .= "\n";
	$msg .= "payee Email = " . $payee_email;
	$msg .= "\n";
	$msg .= "payer Email = " . $payer_email;
	$msg .= "\n";
	$msg .= "payer Name = " . $payer_name;
	$msg .= "\n";
	$msg .= "User ID = " . $user_id;
	$msg .= "\n";
	$msg .= "Subscription = " . $subscription;
	$msg .= "\n";
	$msg .= "Subscribe Date = " . $subscribe_date;
	$msg .= "\n";
	$msg .= "Setup Fee = " . $setup_fee;
	$msg .= "\n";
	$msg .= "Recurrent Charge = " . $recurrent_charge;
	$msg .= "\n";
	$msg .= "Duration = " . $duration;
	$msg .= "\n";
	$msg .= "Trial Period = " . $trial_period;
	$msg .= "\n";
	$msg .= "Stop Date = " . $stop_date;
	$msg .= "\n";
	$msg .= "Subject Matter = " . $subject_matter;
	$msg .= "\n";
	$msg .= "User1 = " . $user1;
	$msg .= "\n";
	$msg .= "User2 = " . $user2;
	$msg .= "\n";
	$msg .= "User3 = " . $user3;
	$msg .= "\n";
	$msg .= "User4 = " . $user4;
	$msg .= "\n";
	$msg .= "User5 = " . $user5;
	$msg .= "\n";
	$msg .= "Shipping Info required? = " . $require_shipping;
	$msg .= "\n";
	$msg .= "Shipping Name = " . $shipping_name;
	$msg .= "\n";
	$msg .= "Shipping Address1 = " . $shipping_address1;
	$msg .= "\n";
	$msg .= "Shipping Address2 = " . $shipping_address2;
	$msg .= "\n";
	$msg .= "Shipping City = " . $shipping_city;
	$msg .= "\n";
	$msg .= "Shipping State/province/district/region = " . $shipping_state;
	$msg .= "\n";
	$msg .= "Shipping Country = " . $shipping_country;
	$msg .= "\n";
	$msg .= "Contact Phone = " . $contact_phone;
	$msg .= "\n";
	$msg .= "Note = " . $note;
	$msg .= "\n";
	$msg .= "\n======= was this a RE-TRY POST on IPN data ? =======\n";
	$msg .= "Retry ID = " . $retry_id;
	$msg .= "\n";
	$msg .= "Retry Count = " . $retry_count;
	$msg .= "IP =" . getenv('REMOTE_ADDR');
	// *** NOTE ***
	// The following mail out is just an EXAMPLE of what you can do with your script.
	// You so NOT need to mail out any info to anyone, if that is NOT part of your requirements.
	// Instead you might want to save the data to a database and do other special processing to meet you own requirements
	// *** END note ***
	//$email_subject = "StormPay IPN Reception Test";
	$from_email = "From: tester@somedomain.com"; // NOTE: you may want to change the FAKE "tester@somedomain.com" to a VALID "From" e-mail address OR set that to "" (NULL)
	 // send out the e-mail message to the PAYEE (OR you can put ANY e-mail address you wish to use to monitor the IPN test - if you hardcode your e-mail address then you can run a BLANK syntax check on this script)
        // NOTE: If this was IPN you received on a REFUND for money you PREVIOUSLY sent, then the payer_email will be YOUR e-mail,
        // so to ensure that this sample script always send you an e-mail message, you may want to "hard code" a special
        // e-mail address for receiving the message rather than use the "payee_email"
	// example - mail("put your e-mail address", $email_subject, $msg, $from_email);  // you can put ANY e-mail address you wish to use to monitor the IPN test - if you hardcode your e-mail address then you can run a BLANK syntax check on this script)
	// *** PLEASE NOTE the following.... ***
	// You can run this script to do a BLANK test on this script for Syntax error and to prove that your script can be reached wherever you located it.
	// To test for syntax error and that you script is accessable, enter in your browser window the following...
	// http://{your server domain}/{directory location of your script}/{Name Of Script file}?payee_email={Your Email Address}
	// After you call you script in your browser with a valid email address for the payee_email, you should get an e-mail feedback.
	// Once you got an e-mail feedback, that is  proof that you can reach your script and that there are no fatal syntax errors.
	// If you script is located on a SECURE server, then you must test your script with HTTPS:// (instead of just http://)
	// *** END note ***
	// ***** NOTE *****
	// The NEXT LINE of code is now a REQUIREMENT.
	// If you do not DELIBERATELY reply with the "HTTP/1.1 202 (Accepted)" response code,
	// StormPay will continue to repeat POST of the IPN data for up to 5 TIMES,
	// normally at 10 minutes interval.
	// ***** END note *****
	// return the HTTP/1.1 202 (Accepted) code - basically means that everything is received AND accepted (processed).
	header("HTTP/1.1 202 Accepted");  // With this line, the POSTing server (in this case StormPay)
                                        // should normally get a "CURL" response = 1 and the HTTP/1.1
                                        // response code = 202.  This is NEEDED to let StormPay know that
                                        // you have RECEIVED the data AND have ACCEPTED (processed) the data.
                                        // Else, the POST will be repeated for up to 5 TIMES in roughly 10 minutes intervals.
  // We personally prefer to explicitely destroy any session variables we might use earlier in a script.
  // If you have special requirements and need to use session, then you should use session.
  // $MY_SESSION_VAR = array();
  // session_destroy();
  die;                        // the process should die anyway, as this is the end of the script, but it is harmless to include this line
  /* *********************************************************************************************
  * All Rights reserved - StormPay Inc. - www.stormpay.com
  * By ALISTER (FRANCISCO) JOHN - ajohn@stormpay.com / ajohn@astroprise.com
  *
  * This is a simple PHP script for retrieving HTTPS (and HTTP) POST on IPN data FROM StormPay.
  * NO special logic is included to check for validity of the data that is retrieved.
  ********************************************************************************************** */
?>
