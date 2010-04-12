<?php 
	include("inc.top.php");
	$q2=new CDB;
	if ($move == "down"){
		$i = 0;
		$q2->query("select * from membership where rank >= $rank order by rank asc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("rank");
				$id_old = $q2->f("id");
				
			}elseif($i == 2){
				$q2->query("UPDATE membership SET rank='$rank_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE membership SET rank='".$q2->f("rank")."' WHERE id=$id_old");
			}else break;
			
		}
	}elseif ($move == "up"){
		$i = 0;
		$q2->query("select * from membership where rank <= $rank order by rank desc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("rank");
				$id_old = $q2->f("id");
				
			}elseif($i == 2){
				$q2->query("UPDATE membership SET rank='$rank_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE membership SET rank='".$q2->f("rank")."' WHERE id=$id_old");
			}else break;
			
		}
	}
	header("Location: membership.php");
	exit;
?>