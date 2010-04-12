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
$q2 = new cdb;
$q3 = new cdb;
$query="select * from members where email='$email' and password='".md5($password)."'";
$q->query($query);
if ($q->nf()==0)
{
	$t->set_file("content", "do.login.error.html");
	include("inc.bottom.php");
}
else
{
	if (get_setting("enable_oto_1")==1)
	{
		$q->next_record();
		if($q->f("ip") == "")
		{
			$q2->query("UPDATE members SET ip='".getenv('REMOTE_ADDR')."', last_login=NOW(), nr_logins=nr_logins+1 WHERE id='".$q->f("id")."'");
		}
		else
		{
			$q2->query("UPDATE members SET ip='".getenv('REMOTE_ADDR')."', last_login=NOW(), nr_logins=nr_logins+1 WHERE id='".$q->f("id")."'");
		}
	
		$sess_id=md5(get_setting("secret_string").$q->f("id"));
		$member_id=$q->f("id");
		$aff=$q->f("aff");	
	
		$_SESSION["sess_id"] = $sess_id;
	
	
		if ($q->f("oto_email")==2)
		{
			$query="select * from menus where alogin=1";
			$q->query($query);
			if ($q->nf()==0)
			{
				header("location:member.area.profile.php");
				die();
			}
			else
			{
				header("location:".$q->f("link"));
				die();
			}
		}
	
		
	
		setcookie("emailx",$q->f("email"),time()+99999);
	
		
	
		// go for OTO page if enabled from admin
		$t->set_file("content", "oto1.html");
		$t->set_var("text_for_popup", get_setting("text_for_popup"));
		$t->set_var("text_no_buy", get_setting("text_no_buy"));
		$query="select * from products where nid='OTO1'";
		$q->query($query);
		$q->next_record();
		$product_id=$q->f("id");
		$session=new_sess_id();
		$step2=0;
		replace_tags_t($member_id, $t);
		$query="update members set oto_email=2 where id='".$member_id."'";
		$q->query($query);
		$ocontent=$t->parse("page", "content");
		$occ_buttons=explode("{OTO1}", "".$ocontent."");
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
	else
	{
		$query="select * from menus where alogin=1";
		$q->query($query);
		if ($q->nf()==0)
		{
			header("location:member.area.profile.php");
		}
		else
		{
			header("location:".$q->f("link"));
			die();
		}
	}
}
?>