<?php 
	include "inc.top.php";
	$query="update settings set value='$enable_arp' where name='enable_arp'";
	$q->query($query);
	
	$query="update settings set value='$arp_message_subject' where name='arp_message_subject'";
	$q->query($query);
	
	$query="update settings set value='$arp_email' where name='arp_email'";
	$q->query($query);
	
	$query="update settings set value='$arp_message_body' where name='arp_message_body'";
	$q->query($query);
	
	set_setting("arp_in_use_type", $arp);
	header("location:signup.settings.php");
?>