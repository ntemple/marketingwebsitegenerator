<?php 
	include("inc.top.php");;
	$t->set_file("content", "admin.add.member.html");
	$t->set_file("membershiplist", "admin.membership.select.html");
	
	$query="select * from membership";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("membership_id", $q->f("id"));
		$t->set_var("membership_name", $q->f("name"));
		$t->parse("membership_list", "membershiplist", true);
	}
	
	include ("inc.bottom.php")
?>
	