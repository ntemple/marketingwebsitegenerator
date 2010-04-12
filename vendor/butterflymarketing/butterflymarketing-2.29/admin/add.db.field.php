<?php 
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