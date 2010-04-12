<?php 
	include ("inc.top.php");
	
	$query="alter table members drop `$id`";
	$q->query($query);
	$q->query("SHOW COLUMNS FROM members");
	$gasit = "";
	while ($q->next_record()){
		preg_match("'^p_.*'",$q->f("Field"),$match);
		$match[0] == "p_".$id ? $gasit .= $match[0]."," : $gasit.= "";
	}
	$gasit = substr($gasit,0,-1);
	if ($gasit){
		$q->query("alter table members drop `$gasit`");
	}
	
	$query="delete from signup_settings where field='$id'";
	$q->query($query);
	$query="delete from tags where field='$id'";
	$q->query($query);
	header("location:add.db.field.php");
?>