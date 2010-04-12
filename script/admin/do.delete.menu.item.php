<?php 
	include("inc.top.php");
	
	$query="delete from menus where id='$id'";
	$q->query($query);
	header("location:menu.php");
	
?>