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
	get_logged_info(); //member area init...
	$member_id=$q->f("id");
	
	$query="insert into messages (id, member_id, from_member_id, subject, body, date_sent, time_sent, read_flag) values (NULL, '$to_member_id', '$member_id', '".addslashes(stripslashes($subject))."','".addslashes(stripslashes($body))."', NOW(), NOW(), 0)";
	$q->query($query);
		
	header("Location: member.area.inbox.php");
		
?>