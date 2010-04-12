<?php
	
	include("inc.top.php");
	$q2=new cdb;
	$q3=new cdb;
$winner=get_setting("make_winner");
$winner.=$camp.":".$id.",";
$q->query("UPDATE settings SET value='$winner' WHERE name='make_winner'");
$q->query("SELECT file from cycle where id='".$id."'");
$q->next_record();
header("location:cycler_stats.php?file=".$q->f("file")."&campa=".$camp);
?>