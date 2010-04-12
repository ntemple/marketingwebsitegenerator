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

 
	
	include("inc.top.php");
	$t->set_file("content", "admin.tags.html");
	$t->set_file("taglist", "admin.tag.row.html");
	$query="select * from tags";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("tag_title", $q->f("title"));
		$t->set_var("tag_field", $q->f("field"));
		$t->set_var("tag_id", $q->f("id"));
		$t->parse("tag_list", "taglist", true);
	}
	if ($notemplate)
	{
		$back="<input type=\"button\" onClick=\"parent.mainFrame.location='".$from.".php?from=".$from."'\" value=\"Back\">";
		$t->set_var("back", $back);
	}
	else
	$t->set_var("back", "");
	if ($q->num_rows()==0) $t->set_var("tag_list", "");
	$b=getdbfields("select",0);
	$t->set_var("fields_list", $b);
	include('inc.bottom.php');
?>