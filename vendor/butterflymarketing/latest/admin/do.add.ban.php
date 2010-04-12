<?php
	include ("inc.top.php");
	
	$query="insert into ban_rules (ban, rule) values ('$ban', '$rule')";
	$q->query($query);
	
	header("location:ban.php");
?>