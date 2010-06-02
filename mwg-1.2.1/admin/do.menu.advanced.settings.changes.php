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
	$q2=new Cdb;
	
	$t->set_file("content", "admin.menu.settings.saved.html");
	
	$query="select name from menus where id='$id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("name")=="Profile Directory")
	{
		$query="update settings set value='$active' where name='enable_profile_directory'";
		$q2->query($query);
	}
	$query="delete from menu_permissions where menu_item='$id'";
	$q->query($query);
	if ($radiobutton=="all")
	{
		$query="update menus set active='$active', open_new_window='$open_new_window' where id='$id'";
		$q->query($query);
	}
	else if ($radiobutton=="just")
	{
		if (count($membership_id)==0) header("location:menu.advanced.settings.php?id=".$id);
		foreach ($membership_id as $x => $value)
		{	
			$query="insert into menu_permissions (menu_item, membership_id) values ('$id', '$x')";
			$q->query($query);
			
		}
		$query="update menus set active='$active', open_new_window='$open_new_window' where id='$id'";
		$q->query($query);
	}
	else 
	{
		$query="update menus set active='$active', open_new_window='$open_new_window' where id='$id'";
		$q->query($query);
	}
	$t->set_file("main", "admin.main.empty.html");
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main");
	
?>