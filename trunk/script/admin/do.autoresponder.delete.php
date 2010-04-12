<?php 
	include("inc.top.php");
	$query="delete from autoresponders where id='$id'";
	$q->query($query);
	header("location:autoresponder.php");
?>