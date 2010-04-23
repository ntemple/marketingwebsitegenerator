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

 
	include "inc.top.php";
	
		$query="SELECT position FROM signup_settings ORDER BY position DESC LIMIT 1";
		$q->query($query);
		$q->next_record();
		$position=$q->f('position');
		$position++;
	
	if (empty($field_name)) $error.="You haven't provided a field name<br>";
	if (empty($field_desc)) $error.="You haven't provided a description<br>";
	if (empty($error))
	{
		
		$query="alter table `members` add ".$field_name;
		if ($fieldtype=='text')
		{
			if (empty($length) || $length<255)
			$query.=" varchar ( 255 ) ";
			else
			$query.=" text ";
		}
		if ($fieldtype=='int')
		{
			if (empty($length))
			$query.=" int ( 11 ) ";
			else
			if ($length<4)
			$query.=" tinyint (".$length.") ";
			else $query.=" int (".$length.") ";
		}
		if (empty($default))
		$query.="NOT NULL";
		else
		$query.="DEFAULT '".$default."' NOT NULL";
		$q->query($query);
		$query="insert into signup_settings (field, description, position) values ('$field_name','$field_desc', '$position')";
		$q->query($query);
		if (!empty($tag))
		{
			$query="insert into tags (title, field) values ('$tag', '$field_name')";
			$q->query($query);
		}
		if ($show_membership){
			$query="alter table `members` add p_".$field_name;
			if ($fieldtype=='text')
			{
				if (empty($length) || $length<255)
				$query.=" varchar ( 255 ) ";
				else
				$query.=" text ";
			}
			if ($fieldtype=='int')
			{
				if (empty($length))
				$query.=" int ( 11 ) ";
				else
				if ($length<4)
				$query.=" tinyint (".$length.") ";
				else $query.=" int (".$length.") ";
			}
			if (empty($default))
			$query.="NOT NULL";
			else
			$query.="DEFAULT '".$default."' NOT NULL";
			$q->query($query);
		}
		header("location:add.db.field.php");
		
	}
	else
	{
		header("location:add.db.field.php?error=".urlencode($error));
	}
	
	
?>