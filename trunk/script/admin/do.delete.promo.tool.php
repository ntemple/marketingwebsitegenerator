<?php 
	include("inc.top.php");
	
	$query="delete from promo_tools where id='$id'";
	$q->query($query);
		
	header("location:promo.tools.php");
	
?>