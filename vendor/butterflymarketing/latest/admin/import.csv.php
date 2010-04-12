<?php 
	include ("inc.top.php");
	if($_GET['err'] == 1){
		$t->set_var("error","Error: duplicate field name(you selected two columns to be inserted in to the same database field)");
	}elseif ($_GET['err'] == 2){	
		$t->set_var("error","Error: error in csv file");
	}else{	
		$t->set_var("error","");
	}
	
	$t->set_file("content", "admin.import.csv.html");
	
	include ("inc.bottom.php");
?>