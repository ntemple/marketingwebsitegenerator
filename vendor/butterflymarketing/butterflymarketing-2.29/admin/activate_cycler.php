<?php
	include ("inc.top.php");
	$q2=new cdb;
	$query="update settings set value='".$activate_cycler."' WHERE name='activate_cycler'";
	$q2->query($query);
	header("location:cycler.php");
?>	