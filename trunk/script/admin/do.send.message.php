<?php 
	include("inc.top.php");
	$member_id=1;
	if ($radiobutton==1)
	{	
		
	
		$query="insert into messages (id, member_id, from_member_id, subject, body, date_sent, time_sent, read_flag) values (NULL, '$to_member_id', '$member_id', '".addslashes(stripslashes($subject))."','".addslashes(stripslashes($body))."', NOW(), NOW(), 0)";
		$q->query($query);
	}
	else if ($radiobutton==2) 
	{
		$query="select email from members where id='$to_member_id'";
		$q->query($query);
		$q->next_record();
		mail($q->f("email"), addslashes(stripslashes($subject)), addslashes(stripslashes($body)), "From: ".get_setting("site_name")." HelpDesk <noreply@".get_setting("site_name").">");
	}
	else if ($radiobutton==3)
	{
		$query="insert into messages (id, member_id, from_member_id, subject, body, date_sent, time_sent, read_flag) values (NULL, '$to_member_id', '$member_id', '".addslashes(stripslashes($subject))."','".addslashes(stripslashes($body))."', NOW(), NOW(), 0)";
		$q->query($query);
		$query="select email from members where id='$to_member_id'";
		$q->query($query);
		$q->next_record();
		mail($q->f("email"), addslashes(stripslashes($subject)), addslashes(stripslashes($body)), "From: ".get_setting("site_name")." HelpDesk <noreply@".get_setting("site_name").">");
	}	
	header("Location: helpdesk.php");
		
?>