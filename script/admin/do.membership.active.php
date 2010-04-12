<?php 
	
	include("inc.top.php");
	$q2=new CDB;
		$updatequery="update membership set active=NOT(active)  where id='".$id."'";
		$q2->query($updatequery);
	header("location:membership.php");
?>