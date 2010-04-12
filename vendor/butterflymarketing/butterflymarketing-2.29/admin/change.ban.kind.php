<?php
	include ("inc.top.php");
	
	$query="update settings set value=not value where name='ban_kind'";
	$q->query($query);
	
	header("location:ban.php");
?>