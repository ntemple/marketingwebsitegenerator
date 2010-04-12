<?php 
	
	include("inc.top.php");
	
	$query="update promo_tools set content='".$_POST["content".$k]."', category='$category' where id='$id'";
	$q->query($query);
	header("location:promo.tools.php");
	
?>