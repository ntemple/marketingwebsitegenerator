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
	
	$t->set_file("content", "admin.add.db.field.html");
	$t->set_file("fieldlist", "admin.fields.html");
	$query="select * from signup_settings where new=1";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("field", $q->f("field"));
		$t->parse("field_list", "fieldlist", true);
	}
	if ($q->nf()==0)
	$t->set_var("field_list","<tr><td colspan=2>No new fields added</td><tr>");
	$t->set_var("error", $error);
	
	include "inc.bottom.php";
?>