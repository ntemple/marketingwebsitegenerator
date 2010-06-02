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


include("inc.all.php");
$q2=new Cdb;
$q3=new Cdb;
if (get_setting("enable_captcha")==1)	{
	require_once("lib/hn_captcha.class.x1.php");
	// ConfigArray
	$folders=get_setting("site_full_url");
	$folders=preg_replace('/http\:\/\/'.$_SERVER['HTTP_HOST'].'/',"",$folders);
	$CAPTCHA_INIT = array(
            'tempfolder'     => $_SERVER['DOCUMENT_ROOT'].$folders."_tmp/",      // string: absolute path (with trailing slash!) to a writeable tempfolder which is also accessible via HTTP!
			'TTF_folder'     => $_SERVER['DOCUMENT_ROOT'].$folders."fonts/", // string: absolute path (with trailing slash!) to folder which contains your TrueType-Fontfiles.
                                // mixed (array or string): basename(s) of TrueType-Fontfiles
//			'TTF_RANGE'      => array('comic.ttf','impact.ttf','LYDIAN.TTF','MREARL.TTF','RUBBERSTAMP.TTF','ZINJARON.TTF'),
			'TTF_RANGE'      => array('comic.ttf','impact.ttf'),
            'chars'          => 5,       // integer: number of chars to use for ID
            'minsize'        => 20,      // integer: minimal size of chars
            'maxsize'        => 30,      // integer: maximal size of chars
            'maxrotation'    => 25,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30
            'noise'          => TRUE,    // boolean: TRUE = noisy chars | FALSE = grid
            'websafecolors'  => FALSE,   // boolean
            'refreshlink'    => TRUE,    // boolean
            'lang'           => 'en',    // string:  ['en'|'de']
            'maxtry'         => 3,       // integer: [1-9]
            'badguys_url'    => '/',     // string: URL
            'secretstring'   => 'A very, very secret string which is used to generate a md5-key!',
            'secretposition' => 24,      // integer: [1-32]
            'debug'          => FALSE,
			
			
		
	);
	$captcha =& new hn_captcha($CAPTCHA_INIT);
$validate=$captcha->validate_submit();
}else $validate=1;
	switch($validate)
	{
	
		// was submitted and has valid keys
		case 1:
	if (get_setting("enable_jv")!=1){
		die("<b>You are not alowed to view this page!</b>");
	}
	if ($email=="")  $error.="You must enter your email address.<br>";
if (get_setting("cut_signup")!=1){
	
	if ($password=="")  $error.="You must enter a password.<br>";
	if ($password!=$cpass)  $error.="Your password doesn't match password confirmation.<br>";
}
	if ($email){
		preg_match("/^[A-Za-z0-9][\w-.]*[A-Za-z0-9]*@[A-Za-z0-9]*([\w-.]*[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i",$_POST['email'],$match);
		if(!@$match[0]){
			$error .= "The email address you filled in is not valid.<br>";
		}
	}
	$query="select * from members where email='$email'";
	$q->query($query);
	if ($q->nf()) $double="&double_email=1";
	if ($jv_code=="") $jv_error=1;//"You must enter the code you received<br>";
	else if ($jv_code!=get_setting("jv_code")) $jv_error=2;//"The code provided for signup is wrong<br>";
	if ($jv_error!=''){
		$str=$_SERVER['HTTP_REFERER'];
			$str= str_replace("&captcha=1","",$str);$str= str_replace("&captcha=2","",$str);
			$str= str_replace("&jv_error=1","",$str);$str= str_replace("&jv_error=2","",$str);
			$str= str_replace("?captcha=1","",$str);$str= str_replace("?captcha=2","",$str);
			$str= str_replace("?jv_error=1","",$str);$str= str_replace("?jv_error=2","",$str);
		$str= str_replace("?double_email=1","",$str);$str= str_replace("&double_email=1","",$str);	
						if (strpos($str,"?"))
							die("<script>
									parent.document.location='".$str."&jv_error=".$jv_error."$double';					
								</script>");
						else 
							die("<script>
									parent.document.location='".$str."?jv_error=".$jv_error."$double';					
								</script>");
		
		}
	$query="select * from members where email='$email'";
	$q->query($query);
	$double_email = 1;
	
	if ($q->nf()!=0){
				if (get_setting("enable_arp")==1 && get_setting("arp_in_use_type")==1){
			
			
						die("
<script>
	parent.document.location='".$_SERVER['HTTP_REFERER']."?double_email=1';					
</script>");
					
			
		}
		$error.="The email address you filled in is already in our database.<br>";
		header ("Location: signup.php?double_email=1");
		exit;
	}
if (get_setting("cut_signup")!=1){	
	$query="select * from signup_settings where atsignup=1 and required=1 and field!='email'";
	$q->query($query);
	while ($q->next_record())
	{
		if ($_POST[$q->f("field")]=="")
		$error.="You must enter your ".$q->f("description")."<br>";
		
	}
		
}
	$membership_id=get_setting("jv_membership");
		$query="select * from membership where id='$membership_id'";
		$q->query($query);
		if ($q->nf()==0)
		{
			$membership_id=get_setting("default_free");
		}
		else
		{
			$q->next_record();
			$membership_id=$q->f("id");
		}
	if ($error!="")
	{
		$t->set_file("content", "signup.error.jv.html");
		foreach ($_POST as $key => $value) 
		{
		  $value = urlencode(stripslashes($value));
		  $req .= "&$key=$value";
		}
		
		$t->set_var("req", $req);
		$t->set_var("errors", $error);
		
	}
	else
	{
		$q2->query("SELECT field FROM signup_settings WHERE atsignup=1 AND new=1");
		$insert_new = "";
		$values_new = "";
		while ($q2->next_record()){
			$insert_new .= ",".$q2->f("field");
			$values_new .= ",'".$_POST[$q2->f("field")]."'";
		}
		$ip = getenv('REMOTE_ADDR');
		if (get_setting('ipblocker')==1){
			if (get_setting('blockfor')==1) $timepass=3600;
			if (get_setting('blockfor')==2) $timepass=3600*24;
			if (get_setting('blockfor')==3) $timepass=3600*48;
			if (get_setting('blockfor')==4) $timepass=3600*24*30;
			if (get_setting('blockfor')==5) 
				$query="SELECT s_date,ip FROM members WHERE ip='".$ip."'";
			else
				$query="SELECT s_date,ip FROM members WHERE ip='".$ip."' AND s_date + '".$timepass."' > ".time();
			$q->query($query);
			$q->next_record();
			if ($q->nf()>0) { 
				die('<script> alert("Your Ip is blocked from joining");parent.window.location="index.php";</script>');
				
			}
		}
		// insert new member in database
		if (get_setting("activation_email")==1) $activationcode=md5(rand(0,9).rand(0,9).rand(0,9).rand(0,9).time());
		else $activationcode="";
		
		$query="insert into members  (
					id,
					email,
					password,
					paypal_email,
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
					code
					$insert_new,
					ip,
					jv,
					active
					)values(
					NULL,
					'$email',
					'".md5($password)."',
					'$paypal_email',
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
					'$activationcode'
					$values_new,
					'$ip',
					'1',
					'1'
					)";
					
		$q->query($query);
		
		$member_id=mysql_insert_id($q->link_id());
    MWG::getInstance()->runEvent('afterSignup', array($member_id, $password)); // NLT Event
		
		updateHistory($member_id, $membership_id, true);
		
		// create the session for this new member
		
			$sess_id = md5(get_setting("secret_string").$member_id);
			$query="update members set mdid='".md5(get_setting("secret_string").$member_id)."' where id='$member_id'";
			$q->query($query);
		
		
		$_SESSION["sess_id"] = $sess_id;
		//Upgrade By Referral
		
		if ($_COOKIE["aff"])
		{
			$query="select count(*) as a from members where aff='".$_COOKIE["aff"]."'";
			$q->query($query);
			$q->next_record();
			$affno=$q->f("a");
			
			$query="select membership_id from members where id='".$_COOKIE["aff"]."'";
			$q->query($query);
			$q->next_record();
			$mid=$q->f("membership_id");
			
			$query="select rank from membership where id='$mid'";
			$q->query($query);
			$q->next_record();
			$mrank=$q->f("rank");
			if (!empty($mrank))
			{
			$query="select * from membership where rank > $mrank";
			$q->query($query);
			while ($q->next_record())
			{
				if ($q->f("ref_no")!=0)
				{
					if ($affno >= $q->f("ref_no") && $q->f("ref_no")>0)
					{
						$query="update members set membership_id='".$q->f("id")."' WHERE id='".$_COOKIE["aff"]."'";
						
						$q3->query($query);
						
						updateHistory($_COOKIE["aff"], $q->f("id"), true);
					}
				}
			}
			
			
			}
			$q->query("SELECT value FROM settings WHERE name='enable_credit'");
			$q->next_record();
			if ($q->f("value")){
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
		
		if ($_COOKIE["aff"] && $q->f("enable")){
			$q->query("INSERT INTO race_stats SET member_id='$member_id', level1_ref=0, race_id='$race_id'");
			$q->query("SELECT level1_ref FROM race_stats WHERE member_id='".$_COOKIE["aff"]."' AND race_id='".$race_id."'");
			$q->next_record();
			$ref_nou = $q->f("level1_ref") + 1;
			if ($q->f("level1_ref")){
				$q->query("UPDATE race_stats SET level1_ref='$ref_nou' WHERE member_id='".$_COOKIE["aff"]."' AND race_id='".$race_id."'");
			}else{
				$q->query("INSERT INTO race_stats SET member_id='".$_COOKIE["aff"]."', level1_ref=1, race_id='$race_id'");
			}
		}
			
		
		//race end
		if (get_setting('send_welcome_emails')==1)
		{
			mwg_mail($email, email_replace(get_setting("welcome_email_subject"), $email, $first_name, $last_name, $password), email_replace(get_setting("welcome_email_body"), $email, $first_name, $last_name, $password), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
if (get_setting('send_welcome_emails') == 1 && get_setting("cut_signup") != 1) {
					mwg_mail($email, email_replace(get_setting("welcome_email_subject"), $email, $first_name, $last_name, $password), email_replace(get_setting("welcome_email_body"), $email, $first_name, $last_name, $password), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
				}
				if (get_setting('activation_email') == 1 && get_setting('activation_email_type') == 1) {
					$emailsubject = get_setting("activation_email_subject");
					$emailsubject = str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$activationcode, $emailsubject);
					$emailbody = get_setting("activation_email_body");
					$emailbody = str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$activationcode, $emailbody);
					mwg_mail($email, email_replace2($emailsubject, $member_id), email_replace2($emailbody, $member_id), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
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
						$member_details = "Name: ".$q2->f("first_name")." ".$q2->f("last_name")."
Email: ".$q2->f("email");
						$query = "select * from tags";
						$q->query($query);
						while ($q->next_record()) {
							$emailsubject = str_replace("{".$q->f("title")."}", $q3->f($q->f("field")), $emailsubject);
							$emailbody = str_replace("{".$q->f("title")."}", $q3->f($q->f("field")), $emailbody);
						}
						$emailbody = str_replace("{member_details}", $member_details, $emailbody);
						$emailbody = str_replace("[sitename]", get_setting("site_name"), $emailbody);
						mwg_mail($email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
					}
				}
			
		}
		if (get_setting("enable_arp")==1 && get_setting("arp_in_use_type")==1){
			$query="select * from autoresponder_config where arp_id='".get_setting("arp_in_use")."' order by id";
			$q->query($query);
			while($q->next_record()){
				if ($q->f('field') == 'url'){
					if ((strpos($q->f('value'),'prosender') || strpos($q->f('value'),'aweber')) && get_setting("free_signup")==1 ){
						die("
<script>
	parent.document.form1.submit();					
</script>");
					}
					elseif ((strpos($q->f('value'),'prosender') || strpos($q->f('value'),'aweber')) && get_setting("free_signup")!=1 && get_setting("enable_oto_paid_signup")!=1){
						$_SESSION['oto_pass'] = 1;
						die("
<script>
	parent.document.form1.submit();					
</script>");
					}
					elseif ((strpos($q->f('value'),'prosender') || strpos($q->f('value'),'aweber')) && get_setting("free_signup")!=1 && get_setting("enable_oto_paid_signup")==1){
						$_SESSION['oto_pass'] = 1;
						die("
<script>
	parent.document.form1.submit();					
</script>");
					}
				}
			}	
		}
		// go for OTO page if enabled from admin
if (get_setting("signup_with_code")==1 && $signup_code==get_setting("signup_code") && get_setting('signup_code_redirect') != ''){
			header("Location: ".get_setting('signup_code_redirect'));
			exit;
		}
		elseif (get_setting("enable_oto_1") && get_setting("free_signup") == 1 && get_setting("give_oto_jv_new")==1)
		{
			header("location: oto.php");
			die();
		}
		elseif (get_setting("enable_oto_1") && !get_setting("enable_oto_paid_signup") && get_setting("give_oto_jv_new")==1){
			
			header("location: oto.php");
			exit;
		}
		else
		{
			header("Location: continue.php".(get_setting("free_signup") == 0 ? "?pay_signup=1" : ""));
		}
}
include("inc.bottom.php");
		case 2:
			$str=$_SERVER['HTTP_REFERER'];
			$query="select * from members where email='$email'";
			$q->query($query);
			if ($q->nf()) $double="&double_email=1";
			$str= str_replace("&captcha=1","",$str);$str= str_replace("&captcha=2","",$str);
			$str= str_replace("&jv_error=1","",$str);$str= str_replace("&jv_error=2","",$str);
			$str= str_replace("?captcha=1","",$str);$str= str_replace("?captcha=2","",$str);
			$str= str_replace("?jv_error=1","",$str);$str= str_replace("?jv_error=2","",$str);
				$str= str_replace("?double_email=1","",$str);$str= str_replace("&double_email=1","",$str);
			if ($jv_code=="") $jv_error="&jv_error=1";//"You must enter the code you received<br>";
			else if ($jv_code!=get_setting("jv_code")) $jv_error="&jv_error=2";//"The code provided for signup is wrong<br>";
							if (strpos($str,"?"))
							die("<script>
									parent.document.location='".$str."&captcha=1$double$jv_error';					
								</script>");
						else 
							die("<script>
									parent.document.location='".$str."?captcha=1$double$jv_error';					
								</script>");
			break;
	
	
		// was submitted, has bad keys and also reached the maximum try's
		case 3:
			$str=$_SERVER['HTTP_REFERER'];
			
			$str= str_replace("&captcha=1","",$str);$str= str_replace("&captcha=2","",$str);
			$str= str_replace("&jv_error=1","",$str);$str= str_replace("&jv_error=2","",$str);
			$str= str_replace("?captcha=1","",$str);$str= str_replace("?captcha=2","",$str);
			$str= str_replace("?jv_error=1","",$str);$str= str_replace("?jv_error=2","",$str);
				$str= str_replace("?double_email=1","",$str);$str= str_replace("&double_email=1","",$str);
			$query="select * from members where email='$email'";
			$q->query($query);
			if ($q->nf()) $double="&double_email=1";
			if ($jv_code=="") $jv_error="&jv_error=1";//"You must enter the code you received<br>";
			else if ($jv_code!=get_setting("jv_code")) $jv_error="&jv_error=2";//"The code provided for signup is wrong<br>";
						if (strpos($str,"?"))
							die("<script>
									parent.document.location='".$str."&captcha=2$double$jv_error';					
								</script>");
						else 
							die("<script>
									parent.document.location='".$str."?captcha=2$double$jv_error';					
								</script>");
//			echo "You have reached the maximum tries... you cannot signup at this time";
			break;
	
	
		// was not submitted, first entry
	
	}
?>
