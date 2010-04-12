<?php 
	
	include("inc.top.php");
	$query="delete from products where id='$id'";
	$q->query($query);
	$query="delete from levels where product_id='$id'";
	$q->query($query);
	header("location:products.php");
?>