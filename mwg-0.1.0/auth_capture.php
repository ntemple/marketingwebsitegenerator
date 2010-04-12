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


include ("inc.all.php");
$q2=new cdb;
$q3=new cdb;
$q2->query("SELECT * FROM members WHERE id='$member_id'");
$q2->next_record();
if ($err!=1 && !$cardNumber){	
	$cardNumber=$_SESSION['temp_cc'];
	$expirationDate=$_SESSION['exp_date'];
}else{
	if ($_POST['year'] && $_POST['month']) {
		$expirationDate=$_POST['year']."-".$_POST['month'];
	}
}
$query="select * from products where id='".$product_id."'";
$q3->query($query);
$q3->next_record();
	
if ($q3->f("recurring_auth")){
	$login = get_setting('auth_login_arb');
	$transkey = get_setting('auth_key_arb');
	$test = get_setting('auth_test2') ? true : false;
	require_once("lib/AuthnetARB.class.php");
	$payment = new AuthnetARB($login, $transkey, $test);
	$payment->setParameter('interval_length', $q3->f("period_auth"));
	$payment->setParameter('interval_unit', $q3->f("type_auth"));
	$payment->setParameter('startDate', date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$q->f('start_auth_subscr'), date("Y"))));
	$payment->setParameter('totalOccurrences', $q3->f("times_auth"));
	$payment->setParameter('trialOccurrences', $q3->f("times_trial_auth"));
	$payment->setParameter('trialAmount', $q3->f("trial_auth_amount"));
	$payment->setParameter('amount', $q3->f("price"));
	$refId = substr($custom,0,20);
	$payment->setParameter('refId', $refId);
	$payment->setParameter('email', $q2->f('email'));
	$payment->setParameter('best_phone', $q2->f('phone'));
	$payment->setParameter('cardNumber', $cardNumber);
	$payment->setParameter('expirationDate', $expirationDate);
	$payment->setParameter('firstName', $q2->f('first_name'));
	$payment->setParameter('lastName', $q2->f('last_name'));
	$payment->setParameter('address', str_replace("\n"," ",$q2->f('address')));
	$payment->setParameter('city', $q2->f('city'));
	if ($company) $payment->setParameter('company', $q2->f('company'));
	$payment->setParameter('state', $q2->f('state'));
	$payment->setParameter('zip', $q2->f('zip'));
	$q3->query("SELECT * FROM countries WHERE id='".$q2->f("country")."'");
	$q3->next_record();
	$payment->setParameter('country', $q3->f("country"));
	$q->query("SELECT product_id, member_id, affiliate_id FROM session WHERE session_id='$custom'");
	$q->next_record();
	$affiliate_id = $q->f('affiliate_id');
	$q->query("SELECT membership_id, nid, display_name FROM products WHERE id='$product_id'");
	$q->next_record();
	$membership_id = $q->f('membership_id');
	$display_name = $q->f('display_name');
	$nid = $q->f('nid');
	$payment->setParameter('subscrName', $q->f('nid'));
	$payment->setParameter('description', $q->f('display_name'));
	$payment->createAccount();
	$auth_check_result = $payment->isSuccessful();
	$txn_id=$payment->getSubscriberID();
	if($auth_check_result) {
		$q->query("UPDATE session SET subscriber_id='".$payment->getSubscriberID()."' WHERE session_id='$custom'");
	}
	if ($q3->f("times_trial_auth")>0) {
		$price_auth = $q3->f('trial_auth_amount');
	} else {
		$price_auth = $q3->f('price');
	}
}else{
	include('lib/auth.class.php');
	$payment = new Authorize();
	$payment->TestMode = get_setting('auth_test') ? true : false;
	$payment->Login = get_setting('auth_login'); 
	$payment->TransactionKey = get_setting('auth_key'); 
	$payment->CardNumber = $cardNumber;
	$payment->ExpiredDate = $expirationDate;
	
	$payment->FirstName = $q2->f('first_name');
	$first_name = $q2->f('first_name');
	$payment->LastName = $q2->f('last_name');
	$last_name = $q2->f('last_name');
	$payment->Address = str_replace("\n"," ",$q2->f('address'));
	$address = $q2->f('address');
	$payment->City = $q2->f('city');
	$city = $q2->f('city');
	$payment->State = $q2->f('state');
	$state = $q2->f('state');
	$payment->Zip = $q2->f('zip');
	$zip = $q2->f('zip');
	$q3->query("SELECT * FROM countries WHERE id='".$q2->f("country")."'");
	$q3->next_record();
	$payment->Country = $q3->f('country');
	$country = $q3->f('country');
	$payment->Phone = $q2->f('home_phone');
	$best_phone = $q2->f('home_phone');
	$payment->Email = $q2->f('email');
	$payment->InvoiceId = $custom;
	$payment->CustomerIp = $ip_address;
	$payment->UserId = $member_id;
	$payment->Company = $q2->f('m_company');
	$company = $q2->f('m_company');
	$q2->query("SELECT * FROM products WHERE id='$product_id'");
	$q2->next_record();
	$payment->Description = $q2->f('nid')." - ".$q2->f('display_name');
	$display_name = $q2->f('display_name');
	$nid = $q2->f('nid');
	$price = $q2->f('price');
	$price_auth = $q2->f('price');
	$payment->Amount = $q2->f('price');
	$auth_check_result = $payment->Pay() && $payment->TransactionId != '' ? true : false;
	$txn_id=$payment->TransactionId;
}
if ($auth_check_result){
	if (get_setting("enable_oto_paid_signup") == 1 && get_setting("free_signup")!=1)
	{ // paid signup and oto's before signup
			
		$q->query("INSERT INTO session SET session_id='".session_id()."', product_id='".$product_id."', affiliate_id='".$_COOKIE['aff']."', paid=1,secret_pay_id='".md5(get_setting('secret_string').$ip)."'");
		if ($product_nid == "OTO2" || $product_nid == "OTO2_BCK") $extra ="?no=3";
		else $extra = "";
		header("Location: continue.php$extra");
	}elseif (get_setting("free_signup")!=1)
	{
		// paid signup
			
		$q2->query("UPDATE session SET paid=1 WHERE member_id='".$member_id."' AND session_id='$custom'");
		$query="select * from session where  session_id='$custom'";
		$q->query($query);
		$q->next_record();
		$s_product_id=$q->f("product_id");
		$s_member_id=$q->f("member_id");
		$s_session=$q->f("session_id");
		$s_paid=$q->f("paid");
		$s_ip=$q->f("ip");
		$refund=1;
		$aff_id=$q->f("affiliate_id");
		$query="select signup,display_name, price,nid from products where id='".$product_id."'";
		$q2->query($query);
		$q2->next_record();
		$product_nid=$q2->f("nid");
		$atsignup=$q2->f("signup");
		$price=$q2->f("price");
		$product_display_name=$q2->f("display_name");
		$comment = "New Payment: product name: ".$product_display_name.", product price: $".$price.", member: $member_id, Affiliate ID: $aff_id";
		$q3->query("INSERT INTO payment_log SET stamp='".time()."', ip='".getenv('REMOTE_ADDR')."', product='".$product_display_name."', txn_id='$txn_id', comment='$comment', process_type='Authorize.net', session_id='$custom', buyer_id ='$member_id', affiliate_id ='$aff_id'");
			
		if ($s_member_id==0)
		{
			$refund=0;
			if ($q->f("affiliate_id")!=0)
			{
				$aff_flag=1;
				$temp_id=$q->f("affiliate_id");
			}
			else $aff_flag=0;
		}
		else
		{
			$aff_flag=0;
			$temp_id=$s_member_id;
		}
		$q->query("SELECT membership_id, nid FROM products WHERE id='".$product_id."'");
		$q->next_record();
		$membership_id=$q->f('membership_id');
		$q->query("SELECT name, rank FROM membership WHERE id='".$membership_id."'");
		$q->next_record();
		$membership_name_ipn = $q->f("name");
		$product_rank_new=$q->f("rank");
			if($member_id!=0){
				$query="SELECT membership_id FROM members WHERE id='$member_id'";
				$q->query($query);
				$q->next_record();
				if ($q->nf()>0) {
					$membership_id_member=$q->f('membership_id');
					$q->query("SELECT rank FROM membership WHERE id='".$q->f('membership_id')."'");
					$q->next_record();
					$member_rank_new=$q->f("rank");
				}
			} else {
				$member_rank_new=0;
			}
			if ($member_rank_new<=$product_rank_new) {
				$membership_id_new=$membership_id;
			} else {
				$membership_id_new=$membership_id_member;
			}
	
		$q2->query("UPDATE members SET membership_id='".$membership_id_new."' WHERE id='".$member_id."'");
		updateHistory($member_id, $membership_id, true);
		if ($aff_id!=0){
			$q2->query("SELECT email, membership_id FROM members WHERE id='$aff_id'");
			$q2->next_record();
			$aff_email = $q2->f('email');
			$aff_membership_id = $q2->f('membership_id');
		}
		if ($price_auth>0) process_sale($price_auth, $temp_id ,$s_product_id, $aff_flag, $s_product_id,$member_id,$custom,$txn_id);
		if (get_setting("sales_email")==1)
		{
			$emailsubject=get_setting("sales_email_subject");
			$emailbody=get_setting("sales_email_body");
			$query="select * from members where id='$aff_id'";
			$q2->query($query);
			$q2->next_record();
			$query="select * from tags";
			$q3->query($query);
			while ($q3->next_record())
			{
				$emailsubject=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailsubject);
				$emailbody=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailbody);
			}
			$emailbody=str_replace("{product}", $product_display_name, $emailbody);
			$emailbody=str_replace("{member_id}", $member_id, $emailbody);
			$emailbody=str_replace("{first_name}", $first_name, $emailbody);
			$emailbody=str_replace("{last_name}", $last_name, $emailbody);
			$query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";
			$q->query($query);
			$q->next_record();
			$paytype = $q->f('paytype');
			if ($jv == 1){
				$jv_amount = $q->f("jv1");
			}elseif ($jv == 2){
				$jv_amount = $q->f("jv2");
			}else {
				if ($q->f("highcom")==1)
				{
					$b=time();
					$c=($aff_s_date+$q->f("highdays")*88400);
					if ($c > $b)
					{
						$jv_amount=$q->f("highval");
					}
					else {
						$jv_amount = $q->f("value");
					}
				}
				else {
					$jv_amount = $q->f("value");
				}
			}
			if ($paytype=="percent") $commsval=$jv_amount*$price/100;
			if ($paytype=="full_amount") $commsval=$jv_amount;
			$emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
			$emailbody=str_replace("{value}", $commsval, $emailbody);
			if($jv_amount != 0){
				@mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
			}
		}
		if ($product_nid == "OTO2" || $product_nid == "OTO2_BCK") $extra ="?no=3";
		else $extra = "";
		header("Location: continue.php$extra");
			
	}else {
			
		$q2->query("UPDATE session SET paid=1 WHERE member_id='".$member_id."' AND session_id='$custom'");
		$query="select * from session where  session_id='$custom'";
		$q->query($query);
		$q->next_record();
		$s_product_id=$q->f("product_id");
		$s_member_id=$q->f("member_id");
		$s_session=$q->f("session_id");
		$s_paid=$q->f("paid");
		$s_ip=$q->f("ip");
		$refund=1;
		$aff_id=$q->f("affiliate_id");
		$query="select signup,display_name, price,nid from products where id='".$product_id."'";
		$q2->query($query);
		$q2->next_record();
		$product_nid=$q2->f("nid");
		$atsignup=$q2->f("signup");
		$price=$q2->f("price");
		$product_display_name=$q2->f("display_name");
		$comment = "New Payment: product name: ".$product_display_name.", product price: $".$price.", member: $member_id, Affiliate ID: $aff_id";
		$q3->query("INSERT INTO payment_log SET stamp='".time()."', ip='".getenv('REMOTE_ADDR')."', product='".$product_display_name."', txn_id='$txn_id', comment='$comment', process_type='Authorize.net', session_id='$custom', buyer_id ='$member_id', affiliate_id ='$aff_id'");
			
		if ($s_member_id==0)
		{
			$refund=0;
			if ($q->f("affiliate_id")!=0)
			{
				$aff_flag=1;
				$temp_id=$q->f("affiliate_id");
			}
			else $aff_flag=0;
		}
		else
		{
			$aff_flag=0;
			$temp_id=$s_member_id;
		}
		$q->query("SELECT membership_id, nid FROM products WHERE id='".$product_id."'");
		$q->next_record();
		$q2->query("UPDATE members SET membership_id='".$q->f('membership_id')."' WHERE id='".$member_id."'");
		updateHistory($member_id, $q->f('membership_id'), true);
		if ($aff_id!=0){
			$q2->query("SELECT email, membership_id FROM members WHERE id='$aff_id'");
			$q2->next_record();
			$aff_email = $q2->f('email');
			$aff_membership_id = $q2->f('membership_id');
		}
		if ($price_auth>0) process_sale($price_auth, $temp_id ,$s_product_id, $aff_flag, $s_product_id,$member_id,$custom,$txn_id);
		if (get_setting("sales_email")==1)
		{
			$emailsubject=get_setting("sales_email_subject");
			$emailbody=get_setting("sales_email_body");
			$query="select * from members where id='$aff_id'";
			$q2->query($query);
			$q2->next_record();
			$query="select * from tags";
			$q3->query($query);
			while ($q3->next_record())
			{
				$emailsubject=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailsubject);
				$emailbody=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailbody);
			}
			$emailbody=str_replace("{product}", $product_display_name, $emailbody);
			$emailbody=str_replace("{member_id}", $member_id, $emailbody);
			$emailbody=str_replace("{first_name}", $first_name, $emailbody);
			$emailbody=str_replace("{last_name}", $last_name, $emailbody);
			$query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";
			$q->query($query);
			$q->next_record();
			$paytype = $q->f('paytype');
			if ($jv == 1){
				$jv_amount = $q->f("jv1");
			}elseif ($jv == 2){
				$jv_amount = $q->f("jv2");
			}else {
				if ($q->f("highcom")==1)
				{
					$b=time();
					$c=($aff_s_date+$q->f("highdays")*88400);
					if ($c > $b)
					{
						$jv_amount=$q->f("highval");
					}
					else {
						$jv_amount = $q->f("value");
					}
				}
				else {
					$jv_amount = $q->f("value");
				}
			}
			if ($paytype=="percent") $commsval=$jv_amount*$price/100;
			if ($paytype=="full_amount") $commsval=$jv_amount;
			$emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
			$emailbody=str_replace("{value}", $commsval, $emailbody);
			if($jv_amount != 0){
				@mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
			}
		}
		header("location: continue.php");
	}
}else{
	?>
<form action="auth_capture.php?err=1" method="post" name="form1">
<table border="0" cellspacing="0" bordercolor="#999999" width="99%"
	cellpadding="5" bgcolor="#FFFFFF" align="center">
	<tr>
		<td valign="top">
		<table width="100%" border="0" cellpadding="0" align="center"
			cellspacing="0">
			<tr>
				<td colspan="2">
				<p><img src="images/SecureCheckout.GIF"
					alt="Authorize.Net Secure Checkout" align="right"></p>
				</td>
			</tr>
			<tr>
				<input type="hidden" value="<?php echo $custom ?>" name="custom" />
				<input type="hidden" value="<?php echo $member_id ?>" name="member_id" />
				<input type="hidden" value="<?php echo $product_id ?>"
					name="product_id" />
				<td width="55%">There was an error in the payment <? echo ($payment->Error ? $payment->Error : $payment->getResponse()) ?></td>
				<td width="45%">
				<div align="right"><br>
				<font face="Arial, Helvetica, sans-serif" size="2">* Required Fields</font></div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<hr size="1" noshade>
				</td>
			</tr>
			<tr>
				<td colspan="2"><font face="Arial, Helvetica, sans-serif"><b><font
					size="2">Payment Information</font></b></font></td>
			</tr>
			<tr>
				<td colspan="2">
				<hr size="1" noshade>
				</td>
			</tr>
			<tr valign="top">
				<td colspan="2">
				<div id="divPaymentMethod" width="100%" align="left"></div>
				<div id="divCreditCardInformation" width="100%" align="left">
				<table id="tableCreditCardInformation" align="center">
					<tbody>
						<tr>
							<td class="SpacerRow2" colspan="2">&nbsp;</td>
						</tr>
						<tr style="display: none;" id="trCCInfoBold">
							<td class="LabelColCC">&nbsp;</td>
							<td class="DataColCC" style="font-weight: bold;">Credit Card
							Information</td>
						</tr>
						<tr id="trAcceptedCardImgs">
							<td class="LabelColCC">&nbsp;</td>
							<td class="DataColCC"><a href="http://usa.visa.com/"
								target="_blank"><img src="images/V.gif" title="Visa" alt="Visa"
								border="0"></a> <a href="http://www.mastercard.com/"
								target="_blank"><img src="images/MC.gif" title="MasterCard"
								alt="MasterCard" border="0"></a> <img src="images/Amex.gif"
								title="American Express" alt="American Express" border="0"> <img
								src="images/Disc.gif" title="Discover" alt="Discover" border="0"></td>
						</tr>
						<tr>
							<td class="LabelColCC">Card Number:</td>
							<td class="DataColCC"><input size="27" type="text"
								id="cardNumber" name="cardNumber" /> *&nbsp;<span
								class="Comment">(enter number without spaces or dashes)</span></td>
						</tr>
						<tr>
							<td class="LabelColCC">Expiration Date:</td>
							<td class="DataColCC"><select name="month">
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select> <select name="year">
								<option value=""></option>
								<option value="2008">2008</option>
								<option value="2009">2009</option>
								<option value="2010">2010</option>
								<option value="2010">2011</option>
								<option value="2010">2012</option>
								<option value="2010">2013</option>
								<option value="2010">2014</option>
								<option value="2010">2015</option>
								<option value="2010">2016</option>
								<option value="2010">2017</option>
								<option value="2010">2018</option>
								<option value="2010">2019</option>
							</select> *&nbsp;<span class="Comment">(select month &amp; year)</span></td>
						</tr>
						<tr>
							<td><input type="submit" value="Submit" /></td>
						</tr>
					</tbody>
				</table>
				</div>
				</td>
			</tr>
		</table>
</table>
</td>
</tr>
<tr>
	<td><a
		href="continue.php?no=<?if ($product_id==1 || $product_id==2) echo 1;elseif ($product_id==11) echo 3;else echo 2; ?>">continue
	to the site</a></td>
</tr>
</table>
</form>
	<?php
}
?>
