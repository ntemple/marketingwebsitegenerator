<?php 
include("inc.all.php");
	
	get_logged_info(); //member area init...
	
	$query="delete from messages where id='$id' && member_id=".$q->f("id");
	$q->query($query);
		
			
			
	
header("Location: member.area.inbox.php");
?>