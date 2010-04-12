<?php 
	include("inc.top.php");
	
	$q->query("SELECT MAX(rank) AS max FROM promo_tools");
	$q->next_record();
	
	$query="insert into promo_tools (id, category, content, template, rank) values (NULL, '$category', '$contentb','$template','".($q->f("max")+1)."')";
	$q->query($query);
	header("location:promo.tools.php");
	include('inc.bottom.php');
?>