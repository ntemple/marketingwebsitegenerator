<?php 
	
	include("inc.top.php");
	foreach ($log as $x => $value)
		{	
			$query="delete from payment_log where id='$x'";
			$q->query($query);
		}
	header("location:payment_log.php");
	include "inc.bottom.php";
?>