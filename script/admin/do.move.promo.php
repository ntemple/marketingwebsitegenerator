<?php 
	include("inc.top.php");
	$q2=new CDB;
	if ($move == "down"){
		$i = 0;
		$q2->query("select * from promo_tools where template=0 AND rank >= $rank order by rank asc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("rank");
				$category_old = $q2->f("category");
				$content_old = str_replace("'","''",$q2->f("content"));
				$template_old = $q2->f("template");
				$id_old = $q2->f("id");
				
			}elseif($i == 2){
				$q2->query("UPDATE promo_tools SET rank='".$q2->f("rank")."$rank_old', category='$category_old', content='$content_old', template='$template_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE promo_tools SET rank='$rank_old', category='".$q2->f("category")."', content='".str_replace("'","''",$q2->f("content"))."', template='".$q2->f("template")."' WHERE id=$id_old");
			}else break;
			
		}
	}elseif ($move == "up"){
		$i = 0;
		$q2->query("select * from promo_tools where template=0 AND rank <= $rank order by rank desc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("rank");
				$category_old = $q2->f("category");
				$content_old = str_replace("'","''",$q2->f("content"));
				$template_old = $q2->f("template");
				$id_old = $q2->f("id");
				
			}elseif($i == 2){
				$q2->query("UPDATE promo_tools SET rank='".$q2->f("rank")."', category='$category_old', content='$content_old', template='$template_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE promo_tools SET rank='$rank_old', category='".$q2->f("category")."', content='".str_replace("'","''",$q2->f("content"))."', template='".$q2->f("template")."' WHERE id=$id_old");
			}else break;
			
		}
	}
	header("Location: promo.tools.php");
	exit;
?>