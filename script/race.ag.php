<?php 
include("inc.top.php");
$q=new Cdb;
$q2=new Cdb;
	$t->set_file("content", "race.ag.html");
	$t->set_file("toplist", "race.top.rows.html");
	get_logged_info();
	$member_id=$q->f("id");
	$query="select * from race_details";
	$q->query($query);
	$q->next_record();
	if ($q->f("enable")==1) $status='<font color=green><strong>Running</strong></font>';
	else if ($q->f("enable")==2) $status='<font color=blue><strong>Paused</strong></font>';
		else if ($q->f("enable")==3) $status='<font color=red><strong>Ended</strong></font>';
	$t->set_var("status", $status);
	if ($q->f("end_type")==1) $conditions='Ending on date: '.$q->f("date_end");
	else if ($q->f("end_type")==2) $conditions='Ending when first place reaches '.$q->f("ref_end").' referrals';
	$t->set_var("conditions", $conditions);
	$t->set_var("started", $q->f("start"));
	$query="select * from race_stats order by level1_ref desc limit 0,20";
	$q->query($query);
	$i=1;
	while ($q->next_record())
	{
		$t->set_var("place", "#".$i);
		$query="select first_name, last_name from members where id='".$q->f("member_id")."'";
		$q2->query($query);
		$q2->next_record();
		$t->set_var("name", $q2->f("first_name")." ".$q2->f("last_name"));
		$t->set_var("refferals", $q->f("level1_ref"));
		$t->parse("top_list", "toplist", true);
		$i++;
	}
include("inc.bottom.php");
?>