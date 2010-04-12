<?php 
	include('inc.all.php');
	$t->set_file("content", "suspended.html");
	$t->set_var("email", get_setting("webmaster_contact_email"));
	include('inc.bottom.php');
?>