<?php 
	
	include("inc.top.php");
	$q2= new CDB;
	$t->set_file("content", "admin.autoresponder.view.stats.html");
	$query="select * from autoresponders where id='$id'";
	$q->query($query);
	$q->next_record();
	
	$t->set_var("message_from", $q->f("from_email"));
	$t->set_var("message_subject", $q->f("subject"));
	$t->set_var("message_header", $q->f("header"));
	$t->set_var("message_body", $q->f("body"));
	$t->set_var("message_footer", $q->f("footer"));
	$t->set_var("message_days", $q->f("days"));
	$t->set_var("autoresponder_id", $q->f("id"));
	$t->set_var("message_count", $q->f("count"));
	if ($q->f("membership")==0) $t->set_var("message_membership", "All");
	else 
	{
		$query="select name from membership where id='".$q->f("membership")."'";
		$q2->query($query);
		$q2->next_record();
		$t->set_var("message_membership", $q2->f("name"));
	}
	$query="select count(*) as n from pending where autoresponder_id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_var("message_left", $q->f("n"));
	
	include('inc.bottom.php');	
?>