<?php 
	include("inc.top.php");
	
	$query="delete from tags where id='$id'";
	$q->query($query);
	echo '<body onLoad="javascript:history.go(-1)">';
?>