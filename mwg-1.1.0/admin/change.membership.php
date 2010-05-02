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
$q2 = new CDb();
	if (isset($page)) {$membership_search_url.=$page;} else {$membership_search_url.="1";}
	
	if (isset($search)) {$membership_search_url.="&search=$search";}
	
	if (isset($criteria)) {$membership_search_url.="&criteria=$criteria";}
	
	$query="select * from membership where active=1";
	$q->query($query);
	while ($q->next_record())
	{
		if (isset($membership_search_hide[$q->f("id")])) {
			$membership_search_url.="&membership_search_hide[".$q->f("id")."]=".$q->f("id");
		}
	}
	
	if (isset($start) && $start!="") {$membership_search_url.="&start=$start&joined=1&from_change_joined=1";}
	
	if (isset($end) && $end!="") {$membership_search_url.="&end=$end";}
	
if (isset($check))
	foreach ($check as $x => $value){	
		
		$query="SELECT * FROM members WHERE id='$x'";
		$q2->query($query);
		$q2->next_record();
		
		$query="SELECT * FROM membership where id='".$q2->f("membership_id")."'";
		$q2->query($query);
		$q2->next_record();
		$first_rank=$q2->f("rank");
		
		$query="SELECT * FROM membership where id='$membership_select'";
		$q2->query($query);
		$q2->next_record();
		$last_rank=$q2->f("rank");	
		
		$query="UPDATE members SET membership_id=$membership_select WHERE id='$x'";
		$q->query($query);
		
		if ($first_rank>$last_rank) {
			$i=0;
			while ($first_rank-$i>$last_rank) {
				
				$rank_to_check=$first_rank-$i;
				$query="SELECT * FROM membership where rank='$rank_to_check'";
				$q2->query($query);
				$q2->next_record();
				updateHistory($x, $q2->f("id"));
				
			$i++;
			}
			
		} elseif ($first_rank<$last_rank) {
			updateHistory($x, $membership_select, true);			
		}
		
	}
	header("location:members.php?page=$membership_search_url");
	exit;
?>