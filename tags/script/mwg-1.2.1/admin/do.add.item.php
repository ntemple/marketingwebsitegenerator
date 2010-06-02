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

 
	
	include("inc.all.php");
	
	if ($menug==2 || $menug==3)
	{
		$rem=" ";
		$menu_category="members";
	}
	elseif ($menug==1)
	{
		$rem="//";
		$menu_category="main";
	}
	
	else
	{
		$rem=" ";
		$menu_category="members";
	}
	if (is_file("../templates/".$filename.".ag.html") && !$update_php)
	{
		die("../templates/".$filename.".ag.html file already exists, not overwriting, please enter another filename");
	}
	
	if (is_file("../".$filename.".ag.php") && !$update_php)
	{
		die("../".$filename.".ag.php file already exists, not overwriting, please enter another filename");
	}
	
	FFileRead("../templates/generate.item.php.html", $phpfile);
	
	$phpfile=str_replace("{rem}", $rem, $phpfile);
	$phpfile=str_replace("{filename}", $filename.".ag.html", $phpfile);
	
	$phpfile=str_replace("{filename_php}", $filename.".ag.php", $phpfile);
	
	if (!$update_php) {
		FFileWriteNew("../templates/".$filename.".ag.html", $contentb, "w");
	}
	
	FFileWriteNew("../".$filename.".ag.php", $phpfile, "w");
	
	
	// the new menu item
	if (!$update_php) {
		
	$query="select position from menus order by position desc limit 0,1";
	$q->query($query);
	$q->next_record();
	$position=$q->f("position")+1;
	if ($menug==1)
	$query="insert into menus (id, menu_category, name, link, position) values
				(NULL, 'main', '$title', '".$filename.".ag.php', '$position')";
	else if ($menug==2)
		$query="insert into menus (id, menu_category, name, link, position) values
					(NULL, 'members', '$title', '".$filename.".ag.php', '$position')";
		else 
		{
			$query="insert into menus (id, menu_category, name, link, position) values
				(NULL, 'main', '$title', '".$filename.".ag.php', '$position')";
			$q->query($query);
			$query="insert into menus (id, menu_category, name, link, position) values
				(NULL, 'members', '$title', '".$filename.".ag.php', '$position')";
		}
	$q->query($query);
	
	
	// the template in the templates list
	
	$query="insert into templates (id, filename, name, description) values
			(NULL, '".$filename.".ag.html', '$title', '$title')";
	$q->query($query);
	
	}
	
	header("Location: generate.item.php?menu=design");
?>