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
	
	$q2=new CDB;
	
	$t->set_file("content", "admin.autoresponder.html");
	$t->set_file("messagelist", "admin.autoresponder.message.row.html");
	$t->set_file("membershiplist", "admin.autoresponder.membership.row.html");
	$t->set_file("taglist", "admin.autoresponder.tag.row.html");
	
	$query="select * from autoresponders";
	$q->query($query);
	while ($q->next_record())
	{
		if ($q->f("sendby")==1) $t->set_var("message_sent_by", "Email Only");
		if ($q->f("sendby")==2) $t->set_var("message_sent_by", "Site Inbox Only");
		if ($q->f("sendby")==3) $t->set_var("message_sent_by", "Email & Site Inbox");
		$t->set_var("message_subject", $q->f("subject"));
		$t->set_var("message_count", $q->f("count"));
		if ($q->f("sent")==1)
			$t->set_var("message_sent", "Yes");
		else
			if ($q->f("sent")==0 && $q->f("days")==0) $t->set_var("message_sent", "No");
			else if ($q->f("days")!=0) $t->set_var("message_sent", "In progress");
		if ($q->f("membership")!=0)
		{	
			$query="select name from membership where id='".$q->f("membership")."'";
			$q2->query($query);
			$q2->next_record();
			$t->set_var("message_membership", $q2->f("name"));
		}
		else $t->set_var("message_membership", "All");
		$t->set_var("message_condition", $q->f("days"));
		
		
		$t->set_var("message_id", $q->f("id"));
		$t->parse("message_list", "messagelist", true);
	}
	if ($q->num_rows()==0) $t->set_var("message_list", "");
	$query="select * from tags";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("tag_title", $q->f("title"));
		$t->set_var("tag_field", $q->f("field"));
		$t->set_var("tag_id", $q->f("id"));
		$t->parse("tag_list", "taglist", true);
	}
	if ($q->num_rows()==0) $t->set_var("tag_list", "");
	$query="select * from membership";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("membership_id", $q->f("id"));
		$t->set_var("membership_name", $q->f("name"));
		$t->parse("membership_list", "membershiplist", true);
	}
	
	$t->set_var("from_name", get_setting("emailing_from_name"));
	$t->set_var("from_email", get_setting("emailing_from_email"));
	if ($filter)
	{
		$t->set_var("filter", stripslashes($filter));
		$query="select count(*) as n from members where ".stripslashes($filter);
		$q->query($query);
		$q->next_record();
		$t->set_var("members", $q->f("n"));
	}
	else 
	{
		$t->set_var("filter", "<b>None</b>");
		$t->set_var("members", "0");
	}
	include('inc.bottom.php');
?>