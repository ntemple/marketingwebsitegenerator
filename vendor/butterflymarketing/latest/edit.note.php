<?php
	include ("inc.top.php");
	get_logged_info();
	$member_id=$q->f("id");
	$query="select * from member_journal where member_id='$member_id' and id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_file("content", "edit_member_notes.html");
	$t->set_var("subject", $q->f("subject"));
	$t->set_var("body", $q->f("body"));
	$t->set_var("note_id", $q->f("id"));
	include ("inc.bottom.php");
?>