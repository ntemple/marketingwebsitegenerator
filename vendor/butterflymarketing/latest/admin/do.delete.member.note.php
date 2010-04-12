<?php 
	
	include("inc.top.php");
	$q->query("DELETE FROM member_notes WHERE id='".$_GET['note_id']."'");
	$query_string = '';
	if ($_GET['from'] == 'activity'){
		header("Location: activity.php?".$_SERVER['QUERY_STRING']);
		exit;
	}else{
		header("Location: members.php?".$_SERVER['QUERY_STRING']);
		exit;
	}
?>