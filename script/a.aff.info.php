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

 
include("inc.top.php");
	 get_logged_info();
	 $q2=new CDB;
	 $query="SELECT id FROM menus WHERE link='a.aff.info.php'";
	 $q2->query($query);
	 $q2->next_record();
	 $query="SELECT membership_id FROM menu_permissions WHERE menu_item='".$q2->f("id")."'";
	 $q2->query($query);
	 while ($q2->next_record()) {
	 	$permissions[]=$q2->f("membership_id");
	 }
	 if (count($permissions)>0) {
	 	$error='<center><font color="red"><b>You do not have access to this area!<br><br>Upgrade your membership level!</b></font></center>';
	 	foreach ($permissions as $value) {
	 		if ($value==$q->f("membership_id")) {
	 			$error='';
	 			break;
	 		}
		}
		if ($error!="") {
			die("$error");
		}
	 }
	$u_sess_id=$q->f("id");
	
	function count_levels($id, $level)
	{
		global $lev, $max_level;
		$q = new Cdb;
		$query="select id from members where aff='$id'";
		$q->query($query);
		$lev[$level]+=$q->nf();
		if ($level+1 <= $max_level)
		while ($q->next_record())
		{
			count_levels($q->f("id"), $level+1);
		}
	}
	$cmember="";
	FFileRead("templates/a.template.aff.info.htm",$cmember);
	
	$cmember=str_replace("{paypal}", $q->f("paypal_email") , $cmember);
	$cmember=str_replace("{ssn}", $q->f("ssn") , $cmember);
	$cmember=str_replace("{currency}",get_setting('paypal_currency'),$cmember);
	$cmember=str_replace("{aff_link}", get_aff_link($u_sess_id) , $cmember);
	$query="select sum(amount) as n from a_tr where status=1 and member_id='$u_sess_id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("n")=="") $n=0; else $n=$q->f("n");
	$cmember=str_replace("{pending}",$n,$cmember);
	
	$query="select sum(amount) as n from a_tr where status=0 and member_id='$u_sess_id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("n")=="") $n=0; else $n=$q->f("n");
	$cmember=str_replace("{total}",$n,$cmember);
	$query="select sum(amount) as n from a_tr where status=2 and member_id='$u_sess_id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("n")=="") $n=0; else $n=$q->f("n");
	$cmember=str_replace("{past}",$n,$cmember);
	$query="select sum(amount) as n from a_tr where status=3 and member_id='$u_sess_id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("n")=="") $n=0; else $n=$q->f("n");
	$cmember=str_replace("{cancelled}",$n,$cmember);
	$cmember=str_replace("{id}",$u_sess_id,$cmember);
	$cmember=str_replace("{rows}",$rows,$cmember);
	$cmember=str_replace("{rows2}",$rows2,$cmember);
	$t->set_var("content", $cmember);
include("inc.bottom.php");
?>