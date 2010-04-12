<?php 
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