<?php
include("inc.all.php");
	$q->query("UPDATE members SET unsub_downline='1' WHERE MD5(CONCAT('".get_setting("secret_string")."-',id))='$code'");
die("You have been unsubscibed.You will not recieve any emails from your affiliate.");
?>