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
	$q->query("SELECT MAX(id) AS max FROM race_details");
	$q->next_record();
	$race_id = $q->f("max");
	
	$insert = "";
	
	if ($end != ""){
		$q->query("UPDATE race_details SET enable=0 WHERE id='$race_id'");
		$q->query("UPDATE menus SET  active=1 WHERE  link='race.ag.php'");
		
	}elseif ($resume != ""){
		if ($opt_race_start == "date"){
			$insert .= "start='".$year_start."-".$month_start."-".$day_start."',";
		}elseif ($opt_race_start == "now"){
			$insert .= "start=NOW(),";
		}
		if ($opt_race_end == 1){
			$insert .= "date_end='".$year_end."-".$month_end."-".$day_end."',";
			$insert .= "end_type=1,";
		}elseif ($opt_race_end == 2){
			if (!$ref_num){
				header("location:race.php");
				exit;
			}
			$insert .= "ref_end='$ref_num',";
			$insert .= "end_type=2,";
		}
		
		$insert = substr($insert,0,-1);
		$q->query("UPDATE menus SET  active=1 WHERE  link='race.ag.php'");
		$q->query("UPDATE race_details SET enable=1,$insert WHERE id='$race_id'");
	}elseif ($pause != ""){
		$q->query("UPDATE race_details SET enable=2 WHERE id='$race_id'");
		$q->query("UPDATE menus SET  active=1 WHERE  link='race.ag.php'");
	}elseif ($start != ""){
		if ($opt_race_start == "date"){
			$insert .= "start='".$year_start."-".$month_start."-".$day_start."',";
		}elseif ($opt_race_start == "now"){
			$insert .= "start=NOW(),";
		}
		
		if ($opt_race_end == 1){
			$insert .= "date_end='".$year_end."-".$month_end."-".$day_end."',";
			$insert .= "end_type=1,";
		}elseif ($opt_race_end == 2){
			$insert .= "ref_end='$ref_num',";
			$insert .= "end_type=2,";
		}
		$q->query("UPDATE menus SET  active=1 WHERE  link='race.ag.php'");
		
		$insert = substr($insert,0,-1);
		$q->query("INSERT INTO race_details SET $insert, enable=1");
	}elseif ($reset != ""){
		$q->query("DELETE FROM race_stats WHERE race_id='$race_id'");
		$q->query("UPDATE menus SET  active=0 WHERE  link='race.ag.php'");
	}
	
	header("location:race.php");
?>