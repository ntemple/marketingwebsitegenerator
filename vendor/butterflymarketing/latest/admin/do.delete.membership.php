<?php 
	
	include("inc.top.php");
	$q=new Cdb;
	$query="select name, id from membership where id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_var("membership", $q->f("name"));
	$t->set_var("id", $q->f("id"));
	$query="select count(*) as a from members where membership_id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_file("content", "admin.delete.membership.html");
	$t->set_var("members", $q->f("a"));
	
	$query="select * from membership where id!='$id'";
	$q->query($query);
	while ($q->next_record())
	{
		$options.='<option value="'.$q->f("id").'">'.$q->f("name").'</option>
		';
	}
	$t->set_var("memberships", $options);
	
	include("inc.bottom.php");
	
?>