<?php 
	include ("inc.top.php");
		$q->query("DELETE FROM temp WHERE  id=$id_temp");
	$t->set_var("rows",$_GET['nr']);
	
	$t->set_file("content", "admin.import.csv.nr_rows.html");
	
	include ("inc.bottom.php");
?>