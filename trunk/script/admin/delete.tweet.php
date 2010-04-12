<?php 
	include("inc.top.php");
$q->query("DELETE FROM twitter WHERE id='".$id."'");
header("location:twitter.php");
?>