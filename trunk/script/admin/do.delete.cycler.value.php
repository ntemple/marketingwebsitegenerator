<?php 
	include("inc.top.php");
	
		$query="delete from cycle where id='$id'";
		$q->query($query);
		
	header("location:cycler.php");
	
?>