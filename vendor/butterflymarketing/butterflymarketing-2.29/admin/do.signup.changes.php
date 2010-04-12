<?php 
	include("inc.top.php");
	$query="update settings set value='$signup_with_code' where name='signup_with_code'";
	$q->query($query);
	$query="update settings set value='$signup_code' where name='signup_code'";
	$q->query($query);
	$query="update settings set value='$credits_enable' where name='enable_credit'";
	$q->query($query);
	$query="update settings set value='$credits' where name='nr_credit'";
	$q->query($query);
	set_setting("text_for_signup_code", $text_for_signup_code);
	header("location:signup.settings.php");
	
?>