<?php 
include("inc.top.php");
	
	get_logged_info(); //member area init...
		$t->set_file("content", "member.area.write.message.html");
		
		$query="select * from members where id='$id'";
		$q->query($query);
		
		if ($q->nf()==0)
		{
			$t->set_file("content", "member.area.error.string.html");
			$t->set_var("error", "The message you requested does not exist in your inbox.");
		}
		else
		{
			$q->next_record();
			
			$t->set_var("to_member_id", $q->f("id"));
			
			$t->set_var("to", $q->f("first_name")." ".$q->f("last_name"));
			
			
			
		}
		
include("inc.bottom.php");
?>