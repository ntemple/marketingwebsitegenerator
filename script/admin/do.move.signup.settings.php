<?php 
	include("inc.top.php");
	$q2=new CDB;
	if ($move == "down"){
		$i = 0;
		$q2->query("select * from signup_settings where position >= $rank order by position asc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("position");
				$description_old = $q2->f("description");
				$atsignup_old = $q2->f("atsignup");
				$required_old = $q2->f("required");
				$membersarea_old = $q2->f("membersarea");
				$field_old = $q2->f("field");
				$new_old = $q2->f("new");
				$id_old = $q2->f("id");
				
			}elseif($i == 2){
				$q2->query("UPDATE signup_settings SET new='$new_old', position='".$q2->f("position")."', field='$field_old', description='$description_old', atsignup='$atsignup_old', required='$required_old', membersarea='$membersarea_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE signup_settings SET new='".$q2->f("new")."', position='$rank_old', field='".$q2->f("field")."', description='".$q2->f("description")."', atsignup='".$q2->f("atsignup")."', required='".$q2->f("required")."', membersarea='".$q2->f("membersarea")."' WHERE id=$id_old");
			}else break;
			
		}
	}elseif ($move == "up"){
		$i = 0;
		$q2->query("select * from signup_settings where position <= $rank order by position desc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("position");
				$description_old = $q2->f("description");
				$atsignup_old = $q2->f("atsignup");
				$required_old = $q2->f("required");
				$membersarea_old = $q2->f("membersarea");
				$field_old = $q2->f("field");
				$new_old = $q2->f("new");
				$id_old = $q2->f("id");
				
			}elseif($i == 2){
				$q2->query("UPDATE signup_settings SET new='$new_old', position='".$q2->f("position")."', field='$field_old', description='$description_old', atsignup='$atsignup_old', required='$required_old', membersarea='$membersarea_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE signup_settings SET new='".$q2->f("new")."', position='$rank_old', field='".$q2->f("field")."', description='".$q2->f("description")."', atsignup='".$q2->f("atsignup")."', required='".$q2->f("required")."', membersarea='".$q2->f("membersarea")."' WHERE id=$id_old");
			}else break;
			
		}
	}
	header("Location: signup.settings.php");
	exit;
?>