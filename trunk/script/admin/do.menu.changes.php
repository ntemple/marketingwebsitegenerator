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

 
	include ("inc.all.php");
	$q2=new CDB;
	$query="update menus set alogin=1 where id='$afterlogin'";
	$q->query($query);
	$query="update menus set alogin=0 where id!='$afterlogin'";
	$q->query($query);
	$query="select id, alogin from menus";
	$q->query($query);
	while ($q->next_record())
	{
		$updatequery="update menus set name='".addslashes($name[$q->f("id")])."', link='".$link[$q->f("id")]."', position='".$position[$q->f("id")]."' where id='".$q->f("id")."'";
		$q2->query($updatequery);
	
	}
	$query="select distinct menu_category from menus";
	$q->query($query);
	while ($q->next_record())
	{
		$update="update settings set value='".$_POST["verticalmenu".$q->f("menu_category")]."' where name='verticalmenu".$q->f("menu_category")."'";
		$q2->query($update);
	}
	header("location:menu.php");
	include ("inc.bottom.php");
?>