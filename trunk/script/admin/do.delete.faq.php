<?php 
	include("inc.top.php");
	
		$query="delete from faq where id='$id'";
		$q->query($query);
		
	header("location:faq.php");
	
?>