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

 
include("inc.all.php");
get_setting('enable_oto_2') == 1 ? $pass = $no : $pass = 1;
$q2=new Cdb;
$query="SELECT * FROM session WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' AND paid=1 order by id desc limit 1";
	$q->query($query);
	$q->next_record();
	$query="SELECT * FROM products WHERE id='".$q->f("product_id")."'";
	$q2->query($query);
	$q2->next_record();
	if ($q2->f("nid") == "OTO1" || $q2->f("nid") == "OTO_BCK")
		$oto1_bought=1;
	else $oto1_bought=0;	
	if ($_SESSION['thank_you']){
		$t->set_file("content","clickbank.thankyou.html");
		$query="select nid, signup,display_name,price from products where id='".$_SESSION['thank_you']."'";
		$q2->query($query);
		$q2->next_record();
		$product_price=$q2->f("price");
		$product_display_name=$q2->f("display_name");
		$t->set_var("product_name",$product_display_name);
		$t->set_var("product_price",$product_price);
		$_SESSION['thank_you']='';		
		if ($no != 0) $extra="?no=".$no;
		$t->set_var("link","continue.php".$extra);
		$t->pparse("out", "content");
		die();
	}
	if ($_GET['pay_signup'] && get_setting("free_signup") == 0)
	{ 
		header("Location: member.area.in.php");
		exit;
	
	}
	elseif (get_setting("enable_oto_2")==1 && $no!=1 && $no!=2 && $oto1_bought==1)
	{
		$q->query("SELECT * FROM session WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' AND paid='1' order by id asc");
		$q->next_record();
		$sesssignup=$q->f("session_id");
		if (get_setting("enable_oto_paid_signup") == 1 && get_setting("free_signup")!=1){
			if ($q->f("affiliate_id")!=0)
	
			{
	
				$query="select membership_id, jv from members where id='".$q->f("affiliate_id")."'";
	
				$q2->query($query);
	
				$q2->next_record();
	
				$aff_m_id=$q2->f("membership_id");
	
				if ($q2->f("jv")!=0)
				{			
					$query="select * from levels where product_id='".$q->f("product_id")."' and level='1' and membership_id='$aff_m_id' and jv".$q2->f("jv")."!=0";
	
				}
				else $query="select * from levels where product_id='".$q->f("product_id")."' and level='1' and membership_id='$aff_m_id' and value!=0";
				$q2->query($query);
	
				if ($q2->nf()==0 || $q2->nf()==1)
	
				{
	
					$spaid1=1;
	
					$spaid2=0;
	
				}	
	
				else
	
				{
	
					$spaid1=1;
	
					$spaid2=1;
	
				}
	
				}		else {
					$spaid1=1;
						$spaid2=0;
				}
	
		} 
		if (get_setting("enable_oto_paid_signup") == 1 && get_setting("free_signup")==0 && $q->f("paid")==$spaid1 && $q->f("paid_step2")==$spaid2 && get_setting("enable_oto2"))
		{	
$_SESSION['oto_bck'] = 1;
			// OTO 2 code goes here...
				$t->set_file("content", "oto2.html");
				$t->set_var("text_for_popup", get_setting("text_for_popup"));
				$t->set_var("text_no_buy", get_setting("text_no_buy"));
				$query="select * from products where nid='OTO2'";
				$q->query($query);
				$q->next_record();
				$product_id=$q->f("id");
				$session=new_sess_id();
				$step2=0;
				
				replace_tags_t($member_id, $t);
	//START CYCLER CODE
	if (get_setting('activate_cycler')){
		if ($_COOKIE['cycle']=='')
		{
			$query="select * from cycle WHERE file='oto2.php' group by cycle";
			$q->query($query);
			$i=0;
			while ($q->next_record())
			{
				$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
				$q2->query($query);
				$q2->next_record();
				if ($q2->nf()){
					$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
				}else{
					$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
					$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
					$q2->query($query);
					$q2->next_record();
					$q3->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
				}
				if ($i==0)
				{
					$cookiecycle=$q2->f("cycle").":".$q2->f("id");
					$i=1;
				}
				else
					$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
				$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
			}
			$ar_host=parse_url(get_setting("site_full_url"));
			$host=$ar_host["host"];
			$path=$ar_host["path"];
			$host=str_replace("www","",$host);
			if ($q->nf() != 0)
				$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto2'");
			setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
		}
		else
		{
			$text=base64_decode($_COOKIE['cycle']);
				$cycle=explode(":", $text);
				$query="select text,file from cycle where id='$cycle[1]'";
				$q->query($query);
				$q->next_record();
				if ($q->f('file') != 'oto2.php'){
					
					$query="select * from cycle WHERE file='oto2.php' group by cycle";
					$q->query($query);
					$i=0;
					while ($q->next_record())
					{
						$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
						$q2->query($query);
						$q2->next_record();
						if ($q2->nf()){
							$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
						}else{
							$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
							$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
							$q2->query($query);
							$q2->next_record();
							$q3->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
						}
						if ($i==0)
						{
							$cookiecycle=$q2->f("cycle").":".$q2->f("id");
							$i=1;
						}
						else
							$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
						$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
					}
					$ar_host=parse_url(get_setting("site_full_url"));
					$host=$ar_host["host"];
					$path=$ar_host["path"];
					$host=str_replace("www","",$host);
					$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto2'");
					setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
							
				}
				$cycle_name = explode("-",$cycle[0]);
				$t->set_var("cycle_".$cycle_name[1], $q->f("text"));
		}
	}
		//END CYCLER CODE
		$ocontent=$t->parse("page", "content");
		$occ_buttons=explode("{OTO2}", "".$ocontent."");
		if (count($occ_buttons)>1) {
		$i=0;
		while ($i<(count($occ_buttons))-1) {
		$rez_button.=$occ_buttons[$i].get_pay_buttons($member_id, $product_id, $aff_id, $session, $step2, $i);
		$i++;
		}	
	}
	$rez_button.=$occ_buttons[$i];
	die ($rez_button);
	
		}elseif (get_setting("enable_oto_paid_signup") != 1 || get_setting("free_signup")==1){
				get_logged_info();
$_SESSION['oto_bck'] = 1;
				$member_id=$q->f("id");
				$aff_id=$q->f("aff");			
			// OTO 2 code goes here...
				$q->query("SELECT products.membership_id FROM members, products WHERE members.id='".$member_id."' AND products.nid='OTO1' AND members.membership_id=products.membership_id");
				if ($q->nf() == 0){
				
		
		
					header("Location: member.area.in.php");
					
					exit;
				}
				$t->set_file("content", "oto2.html");
				$t->set_var("text_for_popup", get_setting("text_for_popup"));
				$t->set_var("text_no_buy", get_setting("text_no_buy"));
				$query="select * from products where nid='OTO2'";
				$q->query($query);
				$q->next_record();	
				$product_id=$q->f("id");
				$session=new_sess_id();
				$step2=0;
				
				replace_tags_t($member_id, $t);
	//START CYCLER CODE
	if (get_setting('activate_cycler')){
		if ($_COOKIE['cycle']=='')
		{
			$query="select * from cycle WHERE file='oto2.php' group by cycle";
			$q->query($query);
			$i=0;
			while ($q->next_record())
			{
				$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
				$q2->query($query);
				$q2->next_record();
				if ($q2->nf()){
					$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
				}else{
					$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
					$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
					$q2->query($query);
					$q2->next_record();
					$q3->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
				}
				if ($i==0)
				{
					$cookiecycle=$q2->f("cycle").":".$q2->f("id");
					$i=1;
				}
				else
					$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
				$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
			}
			$ar_host=parse_url(get_setting("site_full_url"));
			$host=$ar_host["host"];
			$path=$ar_host["path"];
			$host=str_replace("www","",$host);
			if ($q->nf() != 0)
				$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto2'");
			setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
		}
		else
		{
			$text=base64_decode($_COOKIE['cycle']);
				$cycle=explode(":", $text);
				$query="select text,file from cycle where id='$cycle[1]'";
				$q->query($query);
				$q->next_record();
				if ($q->f('file') != 'oto2.php'){
					
					$query="select * from cycle WHERE file='oto2.php' group by cycle";
					$q->query($query);
					$i=0;
					while ($q->next_record())
					{
						$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
						$q2->query($query);
						$q2->next_record();
						if ($q2->nf()){
							$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
						}else{
							$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
							$query="select * from cycle where file='oto2.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
							$q2->query($query);
							$q2->next_record();
							$q3->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
						}
						if ($i==0)
						{
							$cookiecycle=$q2->f("cycle").":".$q2->f("id");
							$i=1;
						}
						else
							$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
						$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
					}
					$ar_host=parse_url(get_setting("site_full_url"));
					$host=$ar_host["host"];
					$path=$ar_host["path"];
					$host=str_replace("www","",$host);
					if ($q->nf() != 0)
						$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto2'");
					setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
							
				}
				$cycle_name = explode("-",$cycle[0]);
				$t->set_var("cycle_".$cycle_name[1], $q->f("text"));
		}
	}
		//END CYCLER CODE
		$ocontent=$t->parse("page", "content");
		$occ_buttons=explode("{OTO2}", "".$ocontent."");
		if (count($occ_buttons)>1) {
		$i=0;
		while ($i<(count($occ_buttons))-1) {
		$rez_button.=$occ_buttons[$i].get_pay_buttons($member_id, $product_id, $aff_id, $session, $step2, $i);
		$i++;
		}	
	}
	$rez_button.=$occ_buttons[$i];
	die ($rez_button);
	
		}
	}
	elseif (get_setting("free_signup") == 0 && $pass != 1 && $pass != 2)
	{
			$query=("SELECT * FROM session WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' AND paid='1' ORDER BY id DESC LIMIT 1");
		$q->query($query);
		$q->next_record();
		$q2->query("SELECT signup,nid FROM products WHERE id='".$q->f('product_id')."'");
		$q2->next_record();
		if ($q2->f('signup') == 0 && ($q2->f('nid') != 'OTO1' || $q2->f('nid') != 'OTO2')){
		
			header("Location: member.area.in.php");
			exit;
		}
		$sesssignup=$q->f("session_id");
		if ($sesssignup == '') die('Fraud Attempt');
			$t->set_file("content","signup.p.html");
			$t->set_var("session_id",$sesssignup);
				$t->set_file("signuplist", "signup.row.html");
$t->set_file("signuplist_b", "signup.row.html");
	
				$t->set_file("confirmpass", "confirm.pass.html");
include("signup.kit.php");
				
				$t->pparse("out", "content");
				die();
	}elseif (get_setting('oto_backup') != '' && $no == 1 && $_SESSION['oto_bck'] != 1){
	$_SESSION['oto_bck'] = 1;
		header("Location: oto_bck.php");
		exit;
	}elseif (get_setting('oto_bck_2') != '' && $no == 1 && $_SESSION['oto2_bck'] != 1 && $_SESSION['oto_bck'] == 1){
		$_SESSION['oto2_bck'] = 1;
		header("Location: oto2_bck.php");
		exit;
	}elseif (get_setting("free_signup") == 0 && get_setting("enable_oto_paid_signup") && ($pass == 1 || $pass == 2) && !isset($sess_id)){
	
			$query=("SELECT * FROM session WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' AND paid='1' order by id asc");
		
		$q->query($query);
		$q->next_record();
		$q2->query("SELECT signup,nid FROM products WHERE id='".$q->f('product_id')."'");
		$q2->next_record();
	
		$sesssignup=$q->f("session_id");
		if ($sesssignup == '') die('Fraud Attempt');
			$t->set_file("content","signup.p.html");
				$t->set_file("signuplist", "signup.row.html");
		$t->set_file("signuplist_b", "signup.row.html");
	
				$t->set_file("confirmpass", "confirm.pass.html");
		$t->set_var("session_id",$sesssignup);
		include("signup.kit.php");
		if ($_SESSION['thank_you2']){
			$query="select nid, signup,display_name,price from products where id='".$_SESSION['thank_you2']."'";
			$q2->query($query);
			$q2->next_record();
			$product_price=$q2->f("price");
			$product_display_name=$q2->f("display_name");
			$t->set_var("product_name",$product_display_name);
			$t->set_var("product_price",$product_price);
			$_SESSION['thank_you2']='';		
			}
				$t->pparse("out", "content");
				die();
	}else{// we just continue to members area... 
		
		
	
				header("Location: member.area.in.php");
	}
?> 