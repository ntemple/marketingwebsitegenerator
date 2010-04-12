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
	
	$q2 = new CDb();
	$q2->query("SELECT MAX(position) AS maxim FROM menus");
	$q2->next_record();
	$item_position = $q2->f("maxim")+1;
	
	if ($item_category=="main" || $item_category=="members")
	$query="insert into menus (name, link, menu_category, position, open_new_window) values ('".addslashes($item_name)."', '$item_link', '$item_category','$item_position','$open_new_window')";
	else 
	if ($item_category==0)
		{
			$query="insert into menus (name, link, menu_category, position, open_new_window) values ('".addslashes($item_name)."', '$item_link', 'main','$item_position','$open_new_window')";
			$q->query($query);
			$query="insert into menus (name, link, menu_category, position, open_new_window) values ('".addslashes($item_name)."', '$item_link', 'members','$item_position','$open_new_window')";
		}
	$q->query($query);
	header("location:menu.php");
	
?>