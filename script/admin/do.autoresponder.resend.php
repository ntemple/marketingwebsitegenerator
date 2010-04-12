<?php 
	include ("inc.top.php");
	$query="update autoresponders set sent=0 where id='$id'";
	$q->query($query);
	header("location:autoresponder.php");
	
?>