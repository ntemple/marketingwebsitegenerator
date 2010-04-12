<?php 
include("inc.top.php");
	get_logged_info(); //member area init...
	$member_id=$q->f("id");
	
	$query="insert into messages (id, member_id, from_member_id, subject, body, date_sent, time_sent, read_flag) values (NULL, '$to_member_id', '$member_id', '".addslashes(stripslashes($subject))."','".addslashes(stripslashes($body))."', NOW(), NOW(), 0)";
	$q->query($query);
		
	header("Location: member.area.inbox.php");
		
?>