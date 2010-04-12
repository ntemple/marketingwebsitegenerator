<?php
	include ("inc.top.php");
	get_logged_info();
	$member_id=$q->f("id");
	$query="insert into member_journal (member_id, subject, body, date_added, date) values ('$member_id', '$subject', '$body', NOW(), '$year-$month-$day')";
	$q->query($query);
	header("location:member.area.notes.php?year=$year&month=$month&day=$day");
?>