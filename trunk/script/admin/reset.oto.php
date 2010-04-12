<?php 
	
	include("inc.top.php");
	
	if ($reset1)
	
		$query="update members set oto1=0";
	
	if ($reset2)
	
		$query="update members set oto2=0";
		
	$q->query($query);
	header("location:index.php");
?>