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
	$from=$from_name." <".$from_email.">";
	if ($filter)
	{
		$query="insert into autoresponders (from_email, subject, header, body, footer, membership, days, filter, sendby) values ('".addslashes($from)."', '".addslashes($subject)."','".addslashes($header)."','".addslashes($body)."','".addslashes($footer)."','$membership','$days','".addslashes($filter)."', '$sendby')";
		$q->query($query);
	}
	else
	{
		$query="insert into autoresponders (from_email, subject, header, body, footer, membership, days, sendby) values ('".addslashes($from)."', '".addslashes($subject)."','".addslashes($header)."','".addslashes($body)."','".addslashes($footer)."','$membership','$days', '$sendby')";
		$q->query($query);
	}
	header("location:autoresponder.php");	
?>