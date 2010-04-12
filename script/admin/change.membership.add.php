<?php 
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
		if ($rem) {
			updateHistory($x, $membership_select_rem);
		} else {
			updateHistory($x, $membership_select_add, true);
		}
	}
	header("location:members.php?page=$membership_search_url");
	exit;
?>