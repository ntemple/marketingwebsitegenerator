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
	$member_id=1;
	if ($radiobutton==1)
	{	
		
	
		$query="insert into messages (id, member_id, from_member_id, subject, body, date_sent, time_sent, read_flag) values (NULL, '$to_member_id', '$member_id', '".addslashes(stripslashes($subject))."','".addslashes(stripslashes($body))."', NOW(), NOW(), 0)";
		$q->query($query);
	}
	else if ($radiobutton==2) 
	{
		$query="select email from members where id='$to_member_id'";
		$q->query($query);
		$q->next_record();
		mail($q->f("email"), addslashes(stripslashes($subject)), addslashes(stripslashes($body)), "From: ".get_setting("site_name")." HelpDesk <noreply@".get_setting("site_name").">");
	}
	else if ($radiobutton==3)
	{
		$query="insert into messages (id, member_id, from_member_id, subject, body, date_sent, time_sent, read_flag) values (NULL, '$to_member_id', '$member_id', '".addslashes(stripslashes($subject))."','".addslashes(stripslashes($body))."', NOW(), NOW(), 0)";
		$q->query($query);
		$query="select email from members where id='$to_member_id'";
		$q->query($query);
		$q->next_record();
		mail($q->f("email"), addslashes(stripslashes($subject)), addslashes(stripslashes($body)), "From: ".get_setting("site_name")." HelpDesk <noreply@".get_setting("site_name").">");
	}	
	header("Location: helpdesk.php");
		
?>