<?php
	
include("inc.top.php");
	
$winner=get_setting("make_winner");
$winner=preg_replace("/".$camp."\:\d+\,/","",$winner);
$q->query("UPDATE settings SET value='$winner' WHERE name='make_winner'");
$q->query("SELECT file from cycle where id='".$id."'");
$q->next_record();
header("location:cycler_stats.php?file=".$q->f("file")."&campa=".$camp);
?>