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


	include ("inc.top.php");
	$t->set_file("content", "admin.ban.html");
	$t->set_file("banrules", "admin.ban.row.html");
	$t->set_file("banlist", "admin.select.option.html");
	if (get_setting("ban_active")!=1)
	{
		$status='<strong><font color="red">Inactive</font></strong>';
		$status_button='Activate Bans';
	}
	else
	{
		$status='<strong><font color="green">Active</font></strong>';
		$status_button='Deactivate Bans';
	}
	$t->set_var("ban_status", $status);
	$t->set_var("ban_change_status", $status_button);
	
	if (get_setting("ban_kind")!=1)
	{
		$kind='<strong>Signup</strong>';
		$kind_button='Change To Total';
	}
	else
	{
		$kind='<strong>Total</strong>';
		$kind_button='Change To Signup';
	}
	$t->set_var("ban_kind", $kind);
	$t->set_var("ban_change_kind", $kind_button);
	
	$query="select * from ban_rules";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("rule_id", $q->f("id"));
		$t->set_var("rule_ban", $q->f("ban"));
		$t->set_var("rule_rule", $q->f("rule"));
		$t->parse("ban_rules", "banrules", true);
	}
	
	if ($q->nf()==0) $t->set_var("ban_rules", "No ban rules set");
	
	$query="select * from signup_settings where atsignup='1'";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("option_value", $q->f("field"));
		$t->set_var("option_text", $q->f("description"));
		$t->parse("ban_list", "banlist", true);
	}
					
	include ("inc.bottom.php");
?>