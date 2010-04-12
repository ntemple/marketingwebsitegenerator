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
	$q->next_record();
	$nr_logins = $q->f('nr_logins') + 1;
	$signup_date = $q->f('s_date');
	$time_count=floor((time()-$signup_date)/3600/24);
	$membership = $q->f('membership_id');
	$msg_viewed = $q->f('msg_viewed');
	if($q->f("ip") == ""){
	
	$q2->query("UPDATE members SET ip='".getenv('REMOTE_ADDR')."', last_login=NOW(), nr_logins=nr_logins+1 WHERE id='".$q->f("id")."'");
}else{
		$q2->query("UPDATE members SET ip='".getenv('REMOTE_ADDR')."', last_login=NOW(), nr_logins=nr_logins+1 WHERE id='".$q->f("id")."'");
}
	$sess_id=md5(get_setting("secret_string").$q->f("id"));
	
	$member_id=$q->f("id");
	$query="update members set mdid='".md5(get_setting("secret_string").$member_id)."' where id='$member_id'";
	mysql_query($query);
	$q2->query("DELETE FROM temp_cc WHERE member_id='$member_id'");	
	$_SESSION["sess_id"] = $sess_id;
	
	setcookie("emailx",$q->f("email"),time()+99999);
	
		// go for OTO page if enabled from admin
		if ($q->f("oto1")==1 && get_setting("enable_oto_1"))
		{
			$query="UPDATE members SET oto1='0' WHERE id='".$q->f("id")."'";
			
			mysql_query($query);
			$t->set_file("content", "oto1.html");
			$t->set_var("text_for_popup", get_setting("text_for_popup"));
			$t->set_var("text_no_buy", get_setting("text_no_buy"));
			
			$query="select * from products where nid='OTO1'";
			$q->query($query);
			$q->next_record();
			
			$product_id=$q->f("id");
			
			$aff_id=$_COOKIE["aff"];
			
			$session=new_sess_id();
			
			$step2=0;
			
			replace_tags_t($member_id, $t);
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
			$query="update members set oto1=0 where id='".$member_id."'";
			$q->query($query);
			die();
		}elseif ($q->f("oto2")==1 && get_setting("enable_oto_2")){
			$t->set_file("content", "oto2.html");
			$query="UPDATE members SET oto2='0' WHERE id='".$q->f("id")."'";
			
			mysql_query($query);
			
			$t->set_var("text_for_popup", get_setting("text_for_popup"));
			$t->set_var("text_no_buy", get_setting("text_no_buy"));
			
			
			$query="select * from products where nid='OTO2'";
			$q->query($query);
			$q->next_record();
			
			$product_id=$q->f("id");
			
			$aff_id=$_COOKIE["aff"];
			
			$session=new_sess_id();
			
			$step2=0;
			
			replace_tags_t($member_id, $t);
			$query="update members set oto2=0 where id='".$member_id."'";
			$q->query($query);
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
		}else{
			
			$q2->query("SELECT * FROM after_login WHERE active=1 AND (FIND_IN_SET('$membership',membership) OR membership='all') ORDER BY nr_days");
			$msg_viewed_arr = explode(",",$msg_viewed);
			
			if ($q2->nf()!=0){
				while ($q2->next_record()){
					if (!in_array($q2->f('id'),$msg_viewed_arr) && $q2->f('count')<=$nr_logins && $q2->f('nr_days')<=$time_count){
						$q3->query("UPDATE members SET msg_viewed=CONCAT(msg_viewed,'".$q2->f('id').",') WHERE id='".$member_id."'");
						die(stripslashes($q2->f('message'))."<br><a href='member.area.in.php'>Thank you for the information, continue to members area</a>");
					} 
				}
					
			}
			$q->query("SELECT link FROM menus WHERE alogin='1'");
			$q->next_record();
			if($q->nf() == 0){
				header("Location: member.area.in.php");
				die();
			}else {
				header("Location: ".$q->f("link"));
				die();
			}
		}
	
}
?>