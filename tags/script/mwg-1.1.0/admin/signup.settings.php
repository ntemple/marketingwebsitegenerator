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

 
include("inc.top.php");
$q2 = new CDb();
	$t->set_file("content", "admin.signup.settings.html");
	$t->set_file("fieldlist", "admin.signup.settings.row.html");
	$query="select * from signup_settings order by position asc";
	$q->query($query);
	$nr_fields = $q->num_rows();
	$i = 0;
	while ($q->next_record())
	{
		$t->set_var("field", $q->f("field"));
		$t->set_var("field_name", $q->f("description"));
		$t->set_var("field_id", $q->f("id"));
		
		if ($q->f("atsignup")==1) $t->set_var("atchecked", "checked");
		else $t->set_var("atchecked", "");
		
		if ($q->f("required")==1) $t->set_var("reqchecked", "checked");
		else $t->set_var("reqchecked", "");
		
		if ($q->f("membersarea")==1) $t->set_var("mchecked", "checked");
		else $t->set_var("mchecked", "");
		
		$t->set_var("field_position", $q->f("position"));
		if ($q->f("field") == "email" || $q->f("field") == "password"){
			$t->set_var("disabled", "disabled");
		}else{
			$t->set_var("disabled", "");
		}
		if ($q->f("field") == "jv_customsales" || $q->f("field") == "jv_customdownload"){
			$t->set_var("disabled1", "disabled");
		}else{
			$t->set_var("disabled1", "");
		}
		$i++;
		if ($i == 1){
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.signup.settings.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=down')\"/>";
		}elseif ($i == $nr_fields){
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.signup.settings.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=up')\"/>";
		}else{
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.signup.settings.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=down')\"/>&nbsp;<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.signup.settings.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=up')\"/>";
		}
		
		$t->set_var("link_move", $link_move);
		$t->parse("field_list", "fieldlist", true);
	}
	if (get_setting("enable_arp")==1) $t->set_var("arpchecked", "checked");
	else $t->set_var("arpchecked", "");
	
	if (get_setting("arp_in_use_type")) $t->set_var("arpselect".get_setting("arp_in_use_type"), "checked");
	
	$t->set_var("arp_email", get_setting("arp_email"));
	$t->set_var("arp_message_subject", get_setting("arp_message_subject"));
	$t->set_var("arp_message_body", get_setting("arp_message_body"));
	$t->set_var("text_for_signup_code", get_setting("text_for_signup_code"));
	
	$t->set_var("activation_email_subject", get_setting("activation_email_subject"));
	$t->set_var("activation_email_body", get_setting("activation_email_body"));
	$t->set_var("signup_code", get_setting("signup_code"));
	
	if (get_setting("enable_credit"))
		$t->set_var("credits_chk", "checked");
	$t->set_var("credits", get_setting("nr_credit"));
	if (get_setting("signup_with_code")==1) $t->set_var("codechecked", "checked");
	else $t->set_var("codechecked", "");
	
	if (get_setting("activation_email")==1) $t->set_var("activationchecked", "checked");
	else $t->set_var("activationchecked", "");
	
	GetTags($tags);
	if (strlen($tags)==0) $t->set_var("tag_list", "");
	else
	{
		$t->set_var("tag_list", $tags);
	}
	
	if (!$_GET['arp_id']){
		$t->set_var("arp_id",get_setting('arp_in_use'));
		$q->query("SELECT * FROM autoresponder_config where arp_id='".get_setting('arp_in_use')."' ORDER BY id");
		$q2->query("SELECT * FROM autoresponder_config where field='arp_name'");
		while ($q2->next_record())
		{
			if ($q2->f("arp_id")==get_setting('arp_in_use'))
			$jump_menu.='<option value="signup.settings.php?arp_id='.$q2->f("arp_id").'" selected>'.$q2->f("value").'</option>';
			else $jump_menu.='<option value="signup.settings.php?arp_id='.$q2->f("arp_id").'">'.$q2->f("value").'</option>';
		}
	}else{
		$t->set_var("arp_id",$_GET['arp_id']);
		set_setting("arp_in_use",$_GET['arp_id']);
		$q->query("SELECT * FROM autoresponder_config where arp_id='".$_GET['arp_id']."' ORDER BY id");
		$q2->query("SELECT * FROM autoresponder_config where field='arp_name'");
		while ($q2->next_record())
		{
			if ($q2->f("arp_id")==$_GET['arp_id'])
			$jump_menu.='<option value="signup.settings.php?arp_id='.$q2->f("arp_id").'" selected>'.$q2->f("value").'</option>';
			else $jump_menu.='<option value="signup.settings.php?arp_id='.$q2->f("arp_id").'">'.$q2->f("value").'</option>';
		}
	}
	$t->set_var("jump_arp",$jump_menu);
	$i = 0;
	while ($q->next_record()){
		if($i<5){
			if ($q->f('field') == 'method')
				$t->set_var('selected'.$q->f('value'),'checked');
			elseif ($q->f('field') == 'url')
				$t->set_var($q->f('field'),(substr($q->f('value'),0,7) != "http://" ? $q->f('value') : substr($q->f('value'),7)));
			else	
				$t->set_var(($q->f('field') == 'arp_name' ? $q->f('field') : $q->f('field')."_arp_new"),$q->f('value'));
		}else{
			$t->set_var("field".($i-4),$q->f('field'));
			$t->set_var("value".($i-4),$q->f('value'));
		}
		$i++;
	}
include("inc.bottom.php");
?>