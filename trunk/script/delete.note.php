<?php
	include ("inc.top.php");
	get_logged_info();
	$member_id=$q->f("id");
	$query="delete from member_journal where member_id='$member_id' and id='$id'";
	$q->query($query);
	header("location:member.area.notes.php");
?>