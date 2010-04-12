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
	 $query="SELECT id FROM menus WHERE link='member.area.inbox.php'";
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
		$t->set_file("content", "member.area.inbox.html");
		$t->set_file("messages_row_file", "member.area.inbox.rows.html");
		
		$query="select * from messages where member_id='".$q->f("id")."'"."ORDER BY date_sent , time_sent DESC";
		$q->query($query);
		
		$q2=new Cdb;
		
		if ($q->nf()==0)
		{
			$t->set_var("from", "NO MESSAGES");
			$t->set_var("subject", "");
			$t->set_var("date", "");
			$t->set_var("time", "");
			$t->set_var("id", "");
			$t->set_var("e_b", "");
			$t->set_var("b", "");
			$t->parse("messages_rows", "messages_row_file", true);
		}
		
		while ($q->next_record())
		{
			$query="select * from members where id='".$q->f("from_member_id")."'";
			$q2->query($query);
			$q2->next_record();
			
			$t->set_var("from", $q2->f("first_name")." ".$q2->f("last_name"));
			if ($q->f("subject")=="")
			{
				$t->set_var("subject", "[no subject]");
			}
			else
			{
				$t->set_var("subject", $q->f("subject"));
			}
			$t->set_var("date", $q->f("date_sent"));
			$t->set_var("time", $q->f("time_sent"));
			$t->set_var("id", $q->f("id"));
			
			if ($q->f("read_flag")==1)
			{
				$t->set_var("e_b", "");
				$t->set_var("b", "");
			}
			else
			{
				$t->set_var("e_b", "</b>");
				$t->set_var("b", "<b>");
			}
			$t->parse("messages_rows", "messages_row_file", true);
			
		}
		
include("inc.bottom.php");
?>