<?php 
include("inc.top.php");
	
		foreach ($check as $x => $value)
		{	
			
		
		$query="select * from messages where member_id='1' and id='$x'";
		$q->query($query);
		
		if ($q->nf()==0)
		{
			$t->set_file("content", "member.area.error.string.html");
			$t->set_var("error", "The message you requested does not exist in your inbox.");
		}
		else
		{
			$query="delete from messages where id='$x'";
		
			$q->query($query);
			
			
		}
}
header("Location: helpdesk.php");
?>