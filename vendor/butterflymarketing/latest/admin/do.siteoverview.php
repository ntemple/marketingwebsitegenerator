<?php 
	include("inc.top.php");
	$selectate = "";
	if ($view == "all"){
		$q->query("select id, name from membership where active=1");
		
		while($q->next_record()){
			$selectate .= $q->f("id").",";
			
		}
		$selectate = substr($selectate,0,-1);
		
	}else{
		foreach ($membership_id as $membership){
			$selectate .= $membership.",";
		}
		$selectate = substr($selectate,0,-1);
	}
	$q->query("UPDATE settings SET value='".$selectate."' WHERE name='site_overview'");
	
	header ("location: siteoverview.php");
	exit;
	
?>	