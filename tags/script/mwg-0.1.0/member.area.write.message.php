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
		$t->set_file("content", "member.area.write.message.html");
		
		$query="select * from members where id='$id'";
		$q->query($query);
		
		if ($q->nf()==0)
		{
			$t->set_file("content", "member.area.error.string.html");
			$t->set_var("error", "The message you requested does not exist in your inbox.");
		}
		else
		{
			$q->next_record();
			
			$t->set_var("to_member_id", $q->f("id"));
			
			$t->set_var("to", $q->f("first_name")." ".$q->f("last_name"));
			
			
			
		}
		
include("inc.bottom.php");
?>