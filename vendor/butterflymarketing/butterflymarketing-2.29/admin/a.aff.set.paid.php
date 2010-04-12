<?php 
	include("inc.top.php");
	
	$q=new Cdb;
	
	$query="update a_tr set status=2,date_paid=NOW() where status=1";
	$q->query($query);
	header("Location: a.adm.main.php");
	
?>
