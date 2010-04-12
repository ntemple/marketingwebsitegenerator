<?php
	include("../inc.top.php");
	$query="update members set unsubscribed=1 where MD5(CONCAT('".get_setting("secret_string")."-',id))='$code'";
	$q->query($query);
	FFileRead("../templates/unsubscribed.html", $content);
	echo $content;
?>