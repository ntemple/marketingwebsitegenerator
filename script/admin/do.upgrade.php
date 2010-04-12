<?php 
	include("inc.top.php");
	$q4 = new CDb();
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
			
		$query="SELECT * FROM members WHERE id='$mid'";
		$q2->query($query);
		$q2->next_record();
		
		$query="SELECT * FROM membership where id='".$q2->f("membership_id")."'";
		$q2->query($query);
		$q2->next_record();
		$first_rank=$q2->f("rank");
		
		$query="SELECT * FROM membership where id='$uid'";
		$q2->query($query);
		$q2->next_record();
		$last_rank=$q2->f("rank");
		
		
		if ($first_rank>$last_rank) {
			$i=0;
			while ($first_rank-$i>$last_rank) {
				
				$rank_to_check=$first_rank-$i;
				$query="SELECT id FROM membership where rank='$rank_to_check'";
				$q2->query($query);
				$q2->next_record();
				updateHistory($mid, $q2->f("id"));
			$i++;
			}
			
		} elseif ($first_rank<$last_rank) {
			updateHistory($mid, $uid, true);			
		}
		
		
	$query="update members set membership_id='$uid', upgrade_date='".time()."' where id='$mid'";
	$q->query($query);
	updateHistory($mid, $uid, true);
	header("location:members.php?page=$membership_search_url");
?>