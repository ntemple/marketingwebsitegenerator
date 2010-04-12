<?php 
	
	include("inc.top.php");
	$memberships = '';
	
	if ($msg_membership == 'all'){
		$memberships = 'all';
	}elseif ($msg_membership == 'just'){
		foreach ($membership as $key=>$value){
			if ($value){
				$memberships .= "$value,";
			}
		}
	}
	if ($memberships!='all') $memberships = substr($memberships,0,-1);
	$q->query("INSERT INTO after_login SET nr_days='$nr_days', count='$count', message='".addslashes($contentb)."', active='$active', membership='$memberships'");
	header("Location: login_msg.php?menu=settings");
?>
