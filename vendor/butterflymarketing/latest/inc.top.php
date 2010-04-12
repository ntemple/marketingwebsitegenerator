<?php 
require_once("inc.all.php");
if (get_setting("activation_email")==1 && $sess_id)
{
	
	$query="select active from members where mdid='$sess_id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("active")!=1){ header("location:activation.php"); exit;}
	
}
if ($sess_id)
{
	$query="select suspended, password from members where mdid='$sess_id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("suspended")==1) {
		header("location:accountsuspended.php");
		die();
	} elseif ($q->f("password")==md5("")) {
		header("location:member.area.in.php?pss=1");
		die();
	}
}
?>