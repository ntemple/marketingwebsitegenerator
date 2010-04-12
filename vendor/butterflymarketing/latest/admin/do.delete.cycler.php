<?php 
	include("inc.top.php");
	
	$query="delete from cycle where cycle='$cycler'";
	$q->query($query);
		
	header("location:cycler.php");
	
?>