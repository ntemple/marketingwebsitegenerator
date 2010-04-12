<?php 
include("inc.all.php");
$q2 = new Cdb;
$q3 = new Cdb;
foreach ($_REQUEST as $key=>$value){
	$mail .= "$key => $value <br>";
}
if($custom!='')
	$sesssignup = $custom;
else {
	$q->query("SELECT * FROM session WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' AND paid='1' order by id asc");
	$q->next_record();
	$sesssignup=$q->f("session_id");
}
if (get_setting("enable_captcha") == 1) {
	require_once("lib/hn_captcha.class.x1.php");
	// ConfigArray
	
	$segs=explode("/",$_SERVER['SCRIPT_FILENAME']);
	$segs[count($segs)-1]='';
	$folders=implode("/",$segs);
	$CAPTCHA_INIT = array(
        'tempfolder' => $folders."_tmp/", // string: absolute path (with trailing slash!) to a writeable tempfolder which is also accessible via HTTP!
        'TTF_folder' => $folders."fonts/", // string: absolute path (with trailing slash!) to folder which contains your TrueType-Fontfiles.
	// mixed (array or string): basename(s) of TrueType-Fontfiles
	//   'TTF_RANGE'      => array('comic.ttf','impact.ttf','LYDIAN.TTF','MREARL.TTF','RUBBERSTAMP.TTF','ZINJARON.TTF'),
        'TTF_RANGE' => array('comic.ttf', 'impact.ttf'),
            'chars' => 5, // integer: number of chars to use for ID
        'minsize' => 20, // integer: minimal size of chars
        'maxsize' => 30, // integer: maximal size of chars
        'maxrotation' => 25, // integer: define the maximal angle for char-rotation, good results are between 0 and 30
        'noise' => TRUE, // boolean: TRUE = noisy chars | FALSE = grid
        'websafecolors' => FALSE, // boolean
        'refreshlink' => TRUE, // boolean
        'lang' => 'en', // string:  ['en'|'de']
        'maxtry' => 3, // integer: [1-9]
        'badguys_url' => '/', // string: URL
        'secretstring' => 'A very, very secret string which is used to generate a md5-key!',
            'secretposition' => 24, // integer: [1-32]
        'debug' => FALSE,
	);
	$captcha = & new hn_captcha($CAPTCHA_INIT);
	$validate = $captcha->validate_submit();
} else {
	$validate = '1';
}
switch($validate) {
	// was submitted and has valid keys
	case 1:
		/*
		 Check if we use auth aim and return $aim_in_use=true; or $aim_in_use=false;
		 */
		$aim_in_use = get_setting('use_aim');
		$q->query("SELECT product_id FROM session WHERE session_id='$custom'");
		
		$q->next_record();
		$product_id = $q->f('product_id');
		$q->query("SELECT membership_id, nid, display_name, recurring_auth FROM products WHERE id='$product_id'");
		$q->next_record();
		$is_recurring = $q->f('recurring_auth');
		$refId=substr($custom,0,20);
		if ($aim_in_use && get_setting("free_signup") != 1 && $cardNumber!='') {
			if ($is_recurring != 0) {
				$login = get_setting('auth_login_arb');
				$transkey = get_setting('auth_key_arb');
				$test = get_setting('auth_test2') ? true : false;
				if ($_POST['year'] && $_POST['month']) {
					$expirationDate = $_POST['year']."-".$_POST['month'];
				}
				
				require_once("lib/AuthnetARB.class.php");
				$arb = new AuthnetARB($login, $transkey, $test);
				$arb->setParameter('interval_length', $interval_length);
				$arb->setParameter('interval_unit', $interval_unit);
				$arb->setParameter('startDate', date("Y-m-d"));
				$arb->setParameter('totalOccurrences', $totalOccurrences);
				$arb->setParameter('trialOccurrences', $trialOccurrences);
				$arb->setParameter('trialAmount', $trialAmount);
				$arb->setParameter('amount', $amount);
				$arb->setParameter('refId', $refId);
				$arb->setParameter('invoiceNumber', $refId);
				$arb->setParameter('email', $email);
				$arb->setParameter('best_phone', $home_phone);
				$arb->setParameter('cardNumber', $cardNumber);
				$arb->setParameter('expirationDate', $expirationDate);
				$arb->setParameter('firstName', $first_name);
				$arb->setParameter('lastName', $last_name);
				$arb->setParameter('address', $address);
				$arb->setParameter('city', $city);
				if ($company) $arb->setParameter('company', $company);
				$arb->setParameter('state', $state);
				$arb->setParameter('zip', $zip);
				$q2->query("SELECT * FROM countries WHERE id='$country'");
				$q2->next_record();
				$arb->setParameter('country', $q2->f("country"));
				$q->query("SELECT * FROM products WHERE id='$product_id'");
				$q->next_record();
				$membership_id = $q->f('membership_id');
				$display_name = $q->f('display_name');
				$nid = $q->f('nid');
				$arb->setParameter('subscrName', $q->f('nid'));
				$arb->setParameter('description', $q->f('display_name'));
				$arb->createAccount();
				$auth_check_result = $arb->isSuccessful();
				if($auth_check_result) {
					$q->query("UPDATE session SET paid=1, subscriber_id='".$arb->getSubscriberID()."' WHERE session_id='$custom'");
					$txn_id=$arb->getSubscriberID();
				}
				if ($q->f("times_trial_auth")>0) {
					$price_auth = $q->f('trial_auth_amount');
				} else {
					$price_auth = $q->f('price');
				}
			} else {
				if ($_POST['year'] && $_POST['month']) {
					$expirationDate = $_POST['month']."-".$_POST['year'];
				}
				include('lib/auth.class.php');
				$payment = new Authorize();
				$payment->Login = get_setting('auth_login'); //$x_login;
				$payment->TransactionKey = get_setting('auth_key'); //$x_tran_key;
				$payment->TestMode = get_setting('auth_test2') ? true : false;
				$payment->CardNumber = $cardNumber;
				$payment->ExpiredDate = str_replace("-", "", $expirationDate);
				$payment->FirstName = $first_name;
				$payment->LastName = $last_name;
				$payment->Address = str_replace("\n", " ", $address);
				$payment->City = $city;
				$payment->State = $state;
				$payment->Zip = $zip;
				$q2->query("SELECT * FROM countries WHERE id='$country'");
				$q2->next_record();
				$payment->Country = $q2->f("country");
				$payment->Phone = $home_phone;
				$payment->Email = $email;
				$payment->InvoiceId = $refId;
				$payment->CustomerIp = $ip_address;
				$payment->UserId = $member_id;
				$payment->Company = $company;
				$q2->query("SELECT * FROM products WHERE id='$product_id'");
				$q2->next_record();
				$price_auth = $q2->f('price');
				$membership_id = $q2->f('membership_id');
				$display_name = $q2->f('display_name');
				$nid = $q2->f('nid');
				$payment->Description = $q2->f('display_name');
				$payment->Amount = $amount;
				$auth_check_result = $payment->Pay() && $payment->TransactionId != '' ? true : false;
				if($auth_check_result){
					$q->query("UPDATE session SET paid=1 WHERE session_id='$custom'");
					$txn_id=$payment->TransactionId;
				}
			}
		}
if ($aim_in_use && isset($cardNumber) && $cardNumber=='' && get_setting('free_signup')==0 ) {
	echo 'There Has Been an Error in the Payment! <br />
	                <b>You need to enter a credit card</b><br>
	                Please hit the back button to reenter the data';
	die();
}
		if ($auth_check_result || ( !isset($cardNumber)) || (get_setting('free_signup')==1) ) {			
			$validation_string = '';
			if (!get_setting("cut_signup")) {
				if ($email == "") $error .= "You must enter your email address.<br>";
				if ($password == "") $error .= "You must enter a password.<br>";
				if ($password != $cpass) $error .= "Your password doesn't match password confirmation.<br>";
			}
			if ($email) {
				preg_match("/^[A-Za-z0-9][\w-.]*[A-Za-z0-9]*@[A-Za-z0-9]*([\w-.]*[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i", $_POST['email'], $match);
				if (!@$match[0]) {
					$error .= "The email address you filled in is not valid.<br>";
				}
			}
			if (!$terms) {
				$error .= "You didn't agree with the terms and conditions.<br>";
			}
			if (get_setting("signup_with_code") == 1 && $signup_code == "") $error .= "You must enter the code you received<br>";
			else if (get_setting("signup_with_code") == 1 && $signup_code != get_setting("signup_code")) $error .= "The code provided for signup is wrong<br>";
			$query = "select * from members where email='$email'";
			$q->query($query);
			$double_email = 1;
			if ($q->nf() != 0) {
				if ((get_setting("enable_arp") == 1 && get_setting("arp_in_use_type") == 1) || (get_setting('free_signup') != 1) ) {
					$str = $_SERVER['HTTP_REFERER'];
					if (strpos($str, "?"))
					die("<script>
                        parent.document.location='".$_SERVER['HTTP_REFERER']."&double_email=1';
                        </script>");
					else
					die("<script>
                        parent.document.location='".$_SERVER['HTTP_REFERER']."?double_email=1';
                        </script>");
				}
				$error .= "The email address you filled in is already in our database.<br>";
				header ("Location: signup.php?double_email=1");
				exit;
			}
			if (!get_setting("cut_signup")) {
				$query = "select * from signup_settings where atsignup=1 and required=1 and field!='email'";
				$q->query($query);
				while ($q->next_record()) {
					if ($_POST[$q->f("field")] == "")
					$error .= "You must enter your ".$q->f("description")."<br>";
				}
			}
			if (get_setting("ban_active") == 1 && get_setting("ban_kind") == 0) {
				$query = "select * from signup_settings where atsignup=1";
				$q->query($query);
				while ($q->next_record()) {
					$query = "select * from ban_rules where ban='".$q->f("field")."'";
					$q2->query($query);
					if ($q2->nf() != 0) {
						while ($q2->next_record()) {
							if ($_POST[$q->f("field")] == $q2->f("rule")) {
								$error = "You are not allowed to join the site";
								break;
							}
						}
					}
				}
			}
			if (!$membership_id)
			$membership_id = get_setting("default_free");
			if ($promo != "NONE" && $promo != "" && trim($promo) != "") {
				$query = "select * from membership where promo_code='$promo'";
				$q->query($query);
				if ($q->nf() == 0) {
					$membership_id = get_setting("default_free");
				} else {
					$q->next_record();
					$membership_id = $q->f("id");
				}
			}
			if ($error != "") {
				
				if ((get_setting("enable_arp") == 1 && get_setting("arp_in_use_type") == 1) &&(get_setting("signup_with_code") == 1 && $signup_code != get_setting("signup_code"))){
				$str = $_SERVER['HTTP_REFERER'];
					die("<script>parent.location='signup.php'</script>");
				}
				if (isset($sesssignup)) $t->set_file("content", "signup.error.p.html");
				else $t->set_file("content", "signup.error.html");
				foreach ($_POST as $key => $value) {
					$value = urlencode(stripslashes($value));
					$req .= "&$key=$value";
				}
				if ($_POST["step2"]) $st = "step2=1";
				else $st = "";
				$t->set_var("return", "pay.return.php?s=".$sesssignup.$st);
				$t->set_var("req", $req);
				$t->set_var("errors", $error);
			} else {
				//CYCLE INSERT
				$cycle = base64_decode($_COOKIE['cycle']);
				$cycle_arr = explode(":", $cycle);
				$cycle_arr_first = explode("-", $cycle_arr[0]);
				$q2->query("SELECT file FROM cycle WHERE id='".$cycle_arr[count($cycle_arr)-1]."'");
				$q2->next_record();
				$q2->query("UPDATE cycle_stats SET used=1 WHERE id='".$cycle_arr_first[0]."'");
				//END CYCLER
				$q2->query("SELECT field FROM signup_settings WHERE atsignup=1 AND new=1");
				$insert_new = "";
				$values_new = "";
				while ($q2->next_record()) {
					$insert_new .= ",".$q2->f("field");
					$values_new .= ",'".$_POST[$q2->f("field")]."'";
				}
				$ip = getenv('REMOTE_ADDR');
				if (get_setting('ipblocker') == 1) {
					if (get_setting('blockfor') == 1) $timepass = 3600;
					if (get_setting('blockfor') == 2) $timepass = 3600 * 24;
					if (get_setting('blockfor') == 3) $timepass = 3600 * 48;
					if (get_setting('blockfor') == 4) $timepass = 3600 * 24 * 30;
					if (get_setting('blockfor') == 5)
					$query = "SELECT s_date,ip FROM members WHERE ip='".$ip."'";
					else
					$query = "SELECT s_date,ip FROM members WHERE ip='".$ip."' AND s_date + '".$timepass."' > ".time();
					$q->query($query);
					$q->next_record();
					if ($q->nf() > 0) {
						die('<script> alert("Your Ip is blocked from joining");parent.window.location="index.php";</script>');
					}
				}
				// insert new member in database
				if (get_setting("activation_email") == 1) $activationcode = md5(rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).time());
				else $activationcode = "";
				if (get_setting("free_signup") == 0) {
					$query = ("SELECT id, product_id FROM `session` WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' AND paid='1' ORDER BY id DESC LIMIT 0,1");
					$q->query($query);
					$q->next_record();
					$query = "select membership_id from products where id='".$q->f("product_id")."'";
					$q2->query($query);
					$q2->next_record();
					$membership_id = $q2->f("membership_id");
					if (get_setting("enable_oto_paid_signup") == 1) {
						$seen = 3;
					}
				}
				$query = "insert into members  (
				id,
				email,
				password,
				paypal_email,
				stormpay_email,
				first_name,
				last_name,
				city,
				state,
				zip,
				country,
				address,
				home_phone,
				work_phone,
				cell_phone,
				icq_id,
				msn_id,
				yahoo_id,
				ssn,
				aff,
				s_date,
				membership_id,
				seen,
				code
				$insert_new,
				ip,last_login
				)values(
				NULL,
				'$email',
				'".md5($password)."',
				'$paypal_email',
				'$stormpay_email',
				'$first_name',
				'$last_name',
				'$city',
				'$state',
				'$zip',
				'$country',
				'$address',
				'$home_phone',
				'$work_phone',
				'$cell_phone',
				'$icq_id',
				'$msn_id',
				'$yahoo_id',
				'$ssn',
				'".$_COOKIE["aff"]."',
                    '".time()."',
				'$membership_id',
				'$seen',
				'$activationcode'
				$values_new,
				'$ip'
				, NOW()
				)";
				$q->query($query);
				$member_id = mysql_insert_id($q->link_id());
				// create the session for this new member
				$sess_id = md5(get_setting("secret_string").$member_id);
				$query = "update members set mdid='".md5(get_setting("secret_string").$member_id)."' where id='$member_id'";
				$q->query($query);
				if (get_setting("enable_oto_paid_signup") == 1 && get_setting("free_signup") == 0) {
						$query = ("SELECT id,session_id,product_id,member_id,affiliate_id FROM `session` WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' AND paid='1' ORDER BY id ");
						$q->query($query);
						if($q->nf()){
							while($q->next_record()){
								$query = "select membership_id from products where id='".$q->f("product_id")."'";
	
								$q2->query($query);
	
								$q2->next_record();
								updateHistory($member_id, $q2->f("membership_id"), true);
								
								
								$q2->query("select buyer_id from a_tr where session='".$q->f("session_id")."'");
								$buyer_id=$q2->f("buyer_id");
								if($buyer_id==0){
									$query = "update a_tr set buyer_id='$member_id'  where session='".$q->f("session_id")."'";
									$q2->query($query);
								}
								$query = "update session set member_id='$member_id'".($_COOKIE['aff']&& $q->f("affiliate_id")==0 ? ",affiliate_id='".$_COOKIE['aff']."'" :"" )." where session_id='".$q->f("session_id")."'";
								$q2->query($query);
								$q2->query("select first_name,last_name from members where id='$member_id'");
								$q2->next_record();
								
								$q2->query("select comment,affiliate_id from payment_log where session_id='".$q->f("session_id")."'");
								$q2->next_record();
								$comment=$q2->f("comment");
								$comment=str_replace('member: 0','member: '.$member_id,$comment);
								$query = "update payment_log set buyer_id='$member_id',comment='".$comment."'".($_COOKIE['aff']&& $q2->f("affiliate_id")==0 ? ",affiliate_id='".$_COOKIE['aff']."'" :"" )." where session_id='".$q->f("session_id")."'";
								$q2->query($query);
							
								
								
							}
						}	
						$query = "update session set secret_pay_id=''  where secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."'";
						$q->query($query);
				}
				if ($auth_check_result && $aim_in_use){
					
					if ($price_auth>0) process_sale($price_auth, $member_id ,$product_id, 0, $product_id, $member_id, $custom);
					
					$comment = "New Payment: product name: ".$display_name.", product price: $".$amount.", member: $member_id, Affiliate ID: ".$_COOKIE["aff"];
					$q3->query("INSERT INTO payment_log SET stamp='".time()."', ip='".getenv('REMOTE_ADDR')."', product='".$display_name."', txn_id='$txn_id', comment='$comment', process_type='Authorize.net', session_id='$custom', buyer_id ='$member_id', affiliate_id ='".$_COOKIE["aff"]."'");
				}
				if ($is_recurring != 0 && $aim_in_use && get_setting("free_signup") == 1){
					$subscrId = $arb->getSubscriberID();
					$arb = new AuthnetARB($login, $transkey, $test);
					$arb->setParameter('subscrId', $subscrId);
					$arb->setParameter('cardNumber', $cardNumber);
					$arb->setParameter('expirationDate', $expirationDate);
					$arb->setParameter('refId', $refId);
					$arb->setParameter('id', $member_id);
					$arb->updateAccount();
				}
				if($cardNumber!=''){
				$_SESSION['temp_cc']=$cardNumber;
				$_SESSION['exp_date']=$expirationDate;
				}
				updateHistory($member_id, $membership_id, true);
				if ($sesssignup && get_setting("free_signup") != 1 && get_setting("enable_oto_paid_signup")!=1) {
					$q3->query("SELECT id, product_id FROM `session` WHERE session_id='$sesssignup' AND paid='1' ORDER BY id DESC");
					$q3->next_record();
					$q->query("SELECT membership_id FROM products WHERE id='".$q3->f('product_id')."'");
					$q->next_record();
					$membership = $q->f("membership_id");
					$query = "update session set member_id='$member_id'  where session_id='$sesssignup'";
					$q->query($query);
					$q2->query("select buyer_id from a_tr where session='$sesssignup'");
					$q2->next_record();
					$buyer_id=$q2->f("buyer_id");
					if($buyer_id==0){
						$q2->query("select first_name,last_name from members where id='$member_id'");
						$q2->next_record();
					
						$query = "update a_tr set buyer_id='$member_id'  where session='$sesssignup'";
						$q->query($query);
						$q2->query("select comment from payment_log where session_id='$sesssignup'");
						$q2->next_record();
						$comment=$q2->f("comment");
						$comment=str_replace('member: 0','member: '.$member_id,$comment);
						$query = "update payment_log set buyer_id='$member_id',comment='".$comment."' where session_id='$sesssignup'";
						$q->query($query);
					}
					
			
					$query = "update session set secret_pay_id=''  where secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."'";
					$q->query($query);
					
				}
				$_SESSION["sess_id"] = $sess_id;
				//Upgrade By Referral
				if ($_COOKIE["aff"]) {
					$query = "select count(*) as a from members where aff='".$_COOKIE["aff"]."'";
					$q->query($query);
					$q->next_record();
					$affno = $q->f("a");
					$query = "select membership_id from members where id='".$_COOKIE["aff"]."'";
					$q->query($query);
					$q->next_record();
					$mid = $q->f("membership_id");
					$query = "select rank from membership where id='$mid'";
					$q->query($query);
					$q->next_record();
					$mrank = $q->f("rank");
					if (!empty($mrank)) {
						$query = "select * from membership where rank > $mrank";
						$q->query($query);
						while ($q->next_record()) {
							if ($q->f("ref_no") != 0) {
								if ($affno >= $q->f("ref_no") && $q->f("ref_no") > 0) {
									$query = "update members set membership_id='".$q->f("id")."' WHERE id='".$_COOKIE["aff"]."'";
									updateHistory($q->f("id"), $_COOKIE["aff"], true);
									$q3->query($query);
								}
							}
						}
					}
					$q->query("SELECT value FROM settings WHERE name='enable_credit'");
					$q->next_record();
					if ($q->f("value")) {
						$q3->query("SELECT credits FROM members WHERE id='".$_COOKIE["aff"]."'");
						$q3->next_record();
						$q2->query("SELECT value FROM settings WHERE name='nr_credit'");
						$q2->next_record();
						$credit_new = $q3->f("credits") + $q2->f("value");
						$q->query("UPDATE members SET credits='".$credit_new."' WHERE id='".$_COOKIE["aff"]."'");
					}
				}
				// end of upgrade
				// send email to new member
				//race
				$q->query("SELECT MAX(id) AS max FROM race_details");
				$q->next_record();
				$race_id = $q->f("max");
				$q->query("SELECT enable FROM race_details WHERE id='".$race_id."'");
				$q->next_record();
				if ($_COOKIE["aff"] && $q->f("enable")) {
					$q->query("SELECT level1_ref FROM race_stats WHERE member_id='".$_COOKIE["aff"]."' AND race_id='".$race_id."'");
					$q->next_record();
					$ref_nou = $q->f("level1_ref") + 1;
					if ($q->f("level1_ref")) {
						$q->query("UPDATE race_stats SET level1_ref='$ref_nou' WHERE member_id='".$_COOKIE["aff"]."' AND race_id='".$race_id."'");
					} else {
						$q->query("INSERT INTO race_stats SET member_id='".$_COOKIE["aff"]."', level1_ref=1, race_id='$race_id'");
					}
				}
				//race end
				//arp
				if (get_setting('enable_arp') == 1 && get_setting('arp_in_use_type') == 2) {
					@mail(get_setting("arp_email"), email_replace2(get_setting("arp_message_subject"), $member_id), email_replace2(get_setting("arp_message_body"), $member_id), "From: ".$first_name." <".$email.">");
				}
				if (get_setting('send_welcome_emails') == 1 && get_setting("cut_signup") != 1) {
					@mail($email, email_replace(get_setting("welcome_email_subject"), $email, $first_name, $last_name, $password), email_replace(get_setting("welcome_email_body"), $email, $first_name, $last_name, $password), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
				}
				if (get_setting('activation_email') == 1 && get_setting('activation_email_type') == 1) {
					$emailsubject = get_setting("activation_email_subject");
					$emailsubject = str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$activationcode, $emailsubject);
					$emailbody = get_setting("activation_email_body");
					$emailbody = str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$activationcode, $emailbody);
					@mail($email, email_replace2($emailsubject, $member_id), email_replace2($emailbody, $member_id), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
				}
				if (get_setting("referral_email") == 1) {
					if ($_COOKIE["aff"] != '') {
						$query = "select * from members where id='".$_COOKIE["aff"]."'";
						$q3->query($query);
						$q3->next_record();
						$email = $q3->f("email");
						$emailsubject = get_setting("referral_email_subject");
						$emailbody = get_setting("referral_email_body");
						$query = "select * from members where id='$member_id'";
						$q2->query($query);
						$q2->next_record();
						$emailbody = str_replace("{buyer_first_name}", $q2->f("first_name"), $emailbody);
						$emailbody = str_replace("{buyer_last_name}", $q2->f("last_name"), $emailbody);
						$emailbody = str_replace("{buyer_id}", $q2->f("id"), $emailbody);
						$emailbody = str_replace("{buyer_email}", $q2->f("email"), $emailbody);
						$member_details = "Id: ".$q2->f("id")."\nName: ".$q2->f("first_name")." ".$q2->f("last_name")."\nEmail: ".$q2->f("email");
						$query = "select * from tags";
						$q->query($query);
						while ($q->next_record()) {
							$emailsubject = str_replace("{".$q->f("title")."}", $q3->f($q->f("field")), $emailsubject);
							$emailbody = str_replace("{".$q->f("title")."}", $q3->f($q->f("field")), $emailbody);
						}
						$emailbody = str_replace("{member_details}", $member_details, $emailbody);
						$emailbody = str_replace("[sitename]", get_setting("site_name"), $emailbody);
						@mail($email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
					}
				}
				
				if (get_setting("enable_arp") == 1 && get_setting("arp_in_use_type") == 1) {
					$query = "select * from autoresponder_config where arp_id='".get_setting("arp_in_use")."' order by id";
					$q->query($query);
					while ($q->next_record()) {
						if ($q->f('field') == 'url') {
							if ((strpos($q->f('value'), 'prosender') || strpos($q->f('value'), 'aweber')) && get_setting("free_signup") == 1 ) {
								die("
                                    <script>
                                    parent.document.form1.submit();
                                    </script>");
							} elseif ((strpos($q->f('value'), 'prosender') || strpos($q->f('value'), 'aweber')) && get_setting("free_signup") != 1 && get_setting("enable_oto_paid_signup") != 1) {
								$_SESSION['oto_pass'] = 1;
								die("
                                    <script>
                                    parent.document.form1.submit();
                                    </script>");
							} elseif ((strpos($q->f('value'), 'prosender') || strpos($q->f('value'), 'aweber')) && get_setting("free_signup") != 1 && get_setting("enable_oto_paid_signup") == 1) {
								$_SESSION['oto_pass'] = 1;
								die("
                                    <script>
                                    parent.document.form1.submit();
                                    </script>");
							}
						}
					}
				}
				if (get_setting("signup_with_code") == 1 && $signup_code == get_setting("signup_code") && get_setting('signup_code_redirect') != '') {
					header("Location: ".get_setting('signup_code_redirect'));
					exit;
				} elseif (get_setting("enable_oto_1") && get_setting("free_signup") == 1) {
					header("location: oto.php");
					die();
				} elseif (get_setting("enable_oto_1") && !get_setting("enable_oto_paid_signup")) {
					header("location: oto.php");
					exit;
				} else {
					header("Location: continue.php".(get_setting("free_signup") == 0 ? "?pay_signup=1" : ""));
				}
			}
			include("inc.bottom.php");
		} else {
			if(get_setting("enable_arp") == 1 && get_setting("arp_in_use_type") == 1){
				$str = $_SERVER['HTTP_REFERER'];
				if ($is_recurring != 0) {
					$errors = 'isError: '.$arb->isError().' | SubscriberID: '.$arb->getSubscriberID().' | Response: '.$arb->getResponse().'ResultCode:'.$arb->getResultCode();
					$q->query("INSERT INTO payment_log SET process_type='Authorize.net', comment='".addslashes($errors)."', stamp='".time()."', product='$product_id', ip='".getenv('REMOTE_ADDR')."', session_id='$custom'");
					die("<script>parent.document.location='".$str."';alert('".addslashes($arb->getResponse())."');</script>");
				}else{
					$errors = 'isError: '.$payment->Error;
					$q->query("INSERT INTO payment_log SET process_type='Authorize.net', comment='".addslashes($errors)."', stamp='".time()."', product='$product_id', ip='".getenv('REMOTE_ADDR')."', session_id='$custom'");
					die("<script>parent.document.location='".$str."';alert('".addslashes($payment->Error)."');</script>");
				}
			}
			if ($is_recurring != 0) {
				$errors = 'isError: '.$arb->isError().' | SubscriberID: '.$arb->getSubscriberID().' | Response: '.$arb->getResponse().'ResultCode:'.$arb->getResultCode();
				$q->query("INSERT INTO payment_log SET process_type='Authorize.net', comment='".addslashes($errors)."', stamp='".time()."', product='$product_id', ip='".getenv('REMOTE_ADDR')."', session_id='$custom'");
				echo 'There Has Been an Error in the Payment! <br />
	                <b>'.$arb->getResponse().'</b><br>
	                Please hit the back button to reenter the data';
				die();
			}else{
				$errors = 'isError: '.$payment->Error;
				$q->query("INSERT INTO payment_log SET process_type='Authorize.net', comment='".addslashes($errors)."', stamp='".time()."', product='$product_id', ip='".getenv('REMOTE_ADDR')."', session_id='$custom'");
				echo 'There Has Been an Error in the Payment! <br />
	                <b>'.$payment->Error.'</b><br>
	                Please hit the back button to reenter the data';
				die();
			}
		}
		break;
	case 2:
		$query = "select * from members where email='$email'";
		$q->query($query);
		if ($q->nf()) $double = "&double_email=1";
		$str = $_SERVER['HTTP_REFERER'];
		$str = str_replace("&captcha=1", "", $str);
		$str = str_replace("&captcha=2", "", $str);
		$str = str_replace("?captcha=1", "", $str);
		$str = str_replace("?captcha=2", "", $str);
		$str = str_replace("?double_email=1", "", $str);
		$str = str_replace("&double_email=1", "", $str);
		if (strpos($str, "?"))
		die("<script>
            parent.document.location='".$str."&captcha=1$double';
		</script>");
		else
		die("<script>
            parent.document.location='".$str."?captcha=1$double';
		</script>");
		break;
		// was submitted, has bad keys and also reached the maximum try's
	case 3:
		$query = "select * from members where email='$email'";
		$q->query($query);
		if ($q->nf()) $double = "&double_email=1";
		$str = $_SERVER['HTTP_REFERER'];
		$str = str_replace("&captcha=1", "", $str);
		$str = str_replace("&captcha=2", "", $str);
		$str = str_replace("?captcha=1", "", $str);
		$str = str_replace("?captcha=2", "", $str);
		$str = str_replace("?double_email=1", "", $str);
		$str = str_replace("&double_email=1", "", $str);
		if (strpos($str, "?"))
		die("<script>
            parent.document.location='".$str."&captcha=2$double';
		</script>");
		else
		die("<script>
            parent.document.location='".$str."?captcha=2$double';
		</script>");
		//   echo "You have reached the maximum tries... you cannot signup at this time";
		break;
		// was not submitted, first entry
		
}
?>