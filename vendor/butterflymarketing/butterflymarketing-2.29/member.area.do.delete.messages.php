<?php 
include("inc.all.php");
	get_logged_info(); //member area init...
if (isset($check))	
	foreach ($check as $x => $value)
	{	
		$query="select * from messages where member_id='".$q->f("id")."' and id='$x'";
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
header("Location: member.area.inbox.php");
?>