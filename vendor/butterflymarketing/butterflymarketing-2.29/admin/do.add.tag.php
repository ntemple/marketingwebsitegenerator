<?php 	
	
	include("inc.top.php");
	$query="insert into tags (title, field) values ('$title','$field')";
	$q->query($query);
	header("location:tags.php");
?>