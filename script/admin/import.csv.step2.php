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

 
	include "inc.top.php";
	
	
	
	FFileRead($file1, $contents);
	
	$q->query("INSERT INTO temp SET content='". addslashes(stripslashes($contents))."'");
	
	$ultim = mysql_insert_id($q->link_id());
	$t->set_var("id_temp",$ultim);
	
	$t->set_file("content", "admin.import.csv.step2.html");
	$t->set_file("fieldlist", "admin.csv.step2.row.html");
	$t->set_file("selectfield", "admin.select.field.csv.html");
	$t->set_file("selectdbfield", "admin.select.db.field.csv.html");
	$content=explode("\n", $contents);
	$fields=explode(",", $content[0]);
	$i=0;
	foreach ($fields as $field)
	{
		if ($i==0) $field=str_replace("\"","", $field);
		if ($i==count($fields)-1) $field=str_replace("\"","", $field);
		$field=str_replace("\"","", $field);
		$t->set_var("field", $i);
		$t->set_var("csv_fields_out", $field);
		$t->parse("csv_fields", "selectfield");
		
		$dbfields=getdbfields("select",0);
		$t->set_var("db_fields", $dbfields);
		$i++;
		$t->parse("field_list", "fieldlist", true);
		$t->unset_var("db_fields");
	}
	include "inc.bottom.php";
?>