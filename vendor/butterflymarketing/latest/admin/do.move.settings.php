<?php 
	include("inc.top.php");
	$q2=new CDB;
	if ($move == "down"){
		$i = 0;
		$q2->query("SELECT * FROM settings WHERE rank >= $rank AND box_type!='hidden' ORDER BY cat, rank ASC");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$cat_old = $q2->f("cat");
				$id_old = $q2->f("id");
				$rank_old = $q2->f("rank");
				
			}elseif(($i == 2) && ($cat_old == $q2->f("cat"))){
				
				$q2->query("UPDATE settings SET rank='$rank_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE settings SET rank='".$q2->f("rank")."' WHERE id='$id_old'");
			}else break;
			
		}
	}elseif ($move == "up"){
		$i = 0;
		$q2->query("SELECT * FROM settings WHERE rank <= $rank AND box_type!='hidden' ORDER BY cat, rank DESC");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$cat_old = $q2->f("cat");
				$rank_old = $q2->f("rank");
				$id_old = $q2->f("id");
				
			}elseif($i == 2 && $cat_old == $q2->f("cat")){
				$q2->query("UPDATE settings SET rank='$rank_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE settings SET rank='".$q2->f("rank")."' WHERE id='$id_old'");
			}else break;
			
		}
	}
	header("Location: settings.php");
	exit;
?>