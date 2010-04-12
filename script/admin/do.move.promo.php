<?php
/**
 * @version    $Id$
 * @package    MWG
 * @copyright  Copyright (C) 2010 Intellispire, LLC. All rights reserved.
 * @license    GNU/GPL v2.0, see LICENSE.txt
 *
 * Marketing Website Generator is free software. 
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

 
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