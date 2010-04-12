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

 
	include "inc.top.php";
	$query="update settings set value='$enable_arp' where name='enable_arp'";
	$q->query($query);
	
	$query="update settings set value='$arp_message_subject' where name='arp_message_subject'";
	$q->query($query);
	
	$query="update settings set value='$arp_email' where name='arp_email'";
	$q->query($query);
	
	$query="update settings set value='$arp_message_body' where name='arp_message_body'";
	$q->query($query);
	
	set_setting("arp_in_use_type", $arp);
	header("location:signup.settings.php");
?>