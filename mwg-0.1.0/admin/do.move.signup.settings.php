<?php
/**
 * @version    $Id: $
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