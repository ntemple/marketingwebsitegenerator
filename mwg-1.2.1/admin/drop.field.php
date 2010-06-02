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

 
	include ("inc.top.php");
	
	$query="alter table members drop `$id`";
	$q->query($query);
	$q->query("SHOW COLUMNS FROM members");
	$gasit = "";
	while ($q->next_record()){
		preg_match("'^p_.*'",$q->f("Field"),$match);
		$match[0] == "p_".$id ? $gasit .= $match[0]."," : $gasit.= "";
	}
	$gasit = substr($gasit,0,-1);
	if ($gasit){
		$q->query("alter table members drop `$gasit`");
	}
	
	$query="delete from signup_settings where field='$id'";
	$q->query($query);
	$query="delete from tags where field='$id'";
	$q->query($query);
	header("location:add.db.field.php");
?>