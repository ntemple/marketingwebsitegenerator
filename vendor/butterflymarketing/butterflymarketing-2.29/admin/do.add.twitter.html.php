<?php 
	include("inc.top.php");
$q->query("UPDATE settings SET value='".$twitter_html."' WHERE name='twitter_html'");
header("location:twitter.php");	
?>