<?php
	
	include("inc.top.php");
	$q2=new CDB;
	get_logged_info(); //member area init...
	$query="update members set paypal_email='$paypal', stormpay_email='$stormpay', ssn='$ssn' where id='".$q->f("id")."'";
	$q2->query($query);
	header("location:a.aff.info.php");
	
?>