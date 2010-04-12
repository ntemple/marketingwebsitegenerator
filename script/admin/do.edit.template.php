<?php 
	include("inc.top.php");
	FFileWrite($filename, html_entity_decode(stripslashes($contentb)));	
	header("location:templates.php");
	
?>