<?php 
	
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