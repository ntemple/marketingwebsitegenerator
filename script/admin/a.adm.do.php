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
	
	$q=new Cdb;
	$q2=new Cdb;
	if($action==2 || $action==3){
		$date_paid=",date_paid='".date("Y-m-d H:i:s")."'";	
	}else $date_paid='';
	if($time_trigger==1){
		$time_interval=" and dt>='".date("Y-m-d",mktime(0,0,0,$month_start,$day_start,$year_start))."' and dt<'".date("Y-m-d",mktime(0,0,0,$month_end,$day_end+1,$year_end))."'";
		$date_vars="&month_start=$month_start&day_start=$day_start&year_start=$year_start&month_end=$month_end&day_end=$day_end&year_end=$year_end&time_trigger=1";
	}
if(count($member)>0){
	foreach ($member as $y => $value)
			{	
				if($time_interval)
					$query="update a_tr set status = '$action' , comments=CONCAT(comments,'$comment'),admin_note=CONCAT(admin_note,'$admin_note')".$date_paid." where member_id='$y' and status='1' and dt>='".date("Y-m-d",mktime(0,0,0,$m_start,$d_start,$y_start))."' and dt<'".date("Y-m-d",mktime(0,0,0,$m_end,$d_end+1,$y_end))."'";
				else $query="update a_tr set status = '$action' , comments=CONCAT(comments,'$comment'),admin_note=CONCAT(admin_note,'$admin_note')".$date_paid." where member_id='$y' and status='1'  ";
				$q->query($query);
			}
}else{
	if($select_all_pages==1){ 
		if($time_interval)
			$query="update a_tr set status = '$action' , comments=CONCAT(comments,'$comment'),admin_note=CONCAT(admin_note,'$admin_note')".$date_paid." where dt>='".date("Y-m-d",mktime(0,0,0,$m_start,$d_start,$y_start))."' and dt<'".date("Y-m-d",mktime(0,0,0,$m_end,$d_end+1,$y_end))."'";
		else $query="update a_tr set status = '$action' , comments=CONCAT(comments,'$comment'),admin_note=CONCAT(admin_note,'$admin_note')".$date_paid." ";
		$q->query($query);
	}else{
		if ($action=="del")
		{
			if (count($check)){
				foreach ($check as $x => $value)
				{	
					$query="delete from a_tr where id = '$x'";
					$q->query($query);
				}
			}
		}
		else
		{
				if ($action != '0' && $action != '1' && $action != '2' && $action != '3' && $action != 'del'){
	
						if ($action == '4'){
							$query="update a_tr set status = '1' , comments=CONCAT(comments,'$comment')";
							$q->query($query);
						}
						if ($action == '5'){
							$query="update a_tr set status = '0' , comments=CONCAT(comments,'$comment')";
							$q->query($query);
						}
						if ($action == '6'){
							$query="update a_tr set status = '2' , comments=CONCAT(comments,'$comment')";
							$q->query($query);
						}
						if ($action == '7'){
							$query="update a_tr set status = '3' , comments=CONCAT(comments,'$comment')";
							$q->query($query);
						}
				}elseif (count($check)){
					
					foreach ($check as $x => $value)
					{	
						$query="update a_tr set status = '$action' , comments=CONCAT(comments,'$comment'),admin_note=CONCAT(admin_note,'$admin_note')".$date_paid." where id='$x'";
						$q->query($query);
					}
				}
		}
	}
}
	header("Location: $last");
?>