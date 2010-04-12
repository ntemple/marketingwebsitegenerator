<?php 
	
	include("inc.top.php");
	$q->query("UPDATE after_login SET message='".addslashes($contentb)."' WHERE id='$id'");
	header("Location: edit_login_msg.php?id=$id");
?>
