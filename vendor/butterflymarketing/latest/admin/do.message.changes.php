<?php 
	include("inc.top.php");
	$q2=new Cdb;
	
	$q->query("SELECT * FROM after_login");
	while ($q->next_record()){
		
		$memberships = '';
	
		if ($_POST['msg_membership_'.$q->f('id')] == 'all'){
			$memberships = 'all';
		}elseif ($_POST['msg_membership_'.$q->f('id')] == 'just'){
			if (isset($_POST['membership_'.$q->f('id')])){
				foreach ($_POST['membership_'.$q->f('id')] as $key=>$value){
					
					if ($value){
						$memberships .= "$value,";
					}
				}
			}
			$memberships = substr($memberships,0,-1);
		}
		
		$q2->query("UPDATE after_login SET nr_days='".$_POST['nr_days_'.$q->f('id')]."', count='".$_POST['count_'.$q->f('id')]."', active='".$_POST['active_'.$q->f('id')]."', membership='$memberships' WHERE id='".$q->f('id')."'");
	}
	header("Location: login_msg.php");
?>