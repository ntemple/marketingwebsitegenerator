<?php
	include ("inc.top.php");
	$q->query("DELETE from ban_rules where id='".$id."'");
	header("Location: ban.php?menu=members");
?>