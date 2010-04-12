<?php
	include ("inc.top.php");
	$q2=new cdb;
	$query="select * from cycle where cycle='$cycle'";
	$q->query($query);
	while ($q->next_record())
	{
		$query="update cycle set cycle='$cycle_name', text='".$_POST["cycle_values_".$q->f("id")]."' where id='".$q->f("id")."'";
		$q2->query($query);
	}
	header("location:cycler.php");
?>	