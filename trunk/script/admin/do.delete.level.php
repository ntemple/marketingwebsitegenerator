<?php 
	include("inc.top.php");
	$query="select * from levels where id='$id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("paytype")=="percent_split" || $q->f("paytype")=="full_amount_split")
	$query="delete from levels where id='$id' or id='".($id + 1)."'";
	else $query="delete from levels where id='$id'";
	$q->query($query);
	header("location:levels.php");
?>