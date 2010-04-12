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
	
		
		$t->set_file("content", "admin.inbox.html");
		$t->set_file("messages_row_file", "admin.inbox.rows.html");
		
		$query="select * from messages where member_id='1'"."ORDER BY date_sent , time_sent DESC";
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
			$t->set_var("member_id","");
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
			$t->set_var("member_id","<a href=members.php?menu=members&action=search&search=id&criteria=".$q->f("from_member_id").">".$q->f("from_member_id")."</a>");
			
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