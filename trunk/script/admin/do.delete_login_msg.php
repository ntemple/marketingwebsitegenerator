<?php 
	
	include("inc.top.php");
	$q->query("DELETE FROM after_login WHERE id='$id'");
	
	header("Location: login_msg.php");
	
?>