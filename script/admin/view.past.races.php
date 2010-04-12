<?php 
	include("inc.top.php");
	$t->set_file("content", "admin.past.races.html");
	
	$t->set_file("statistics_f", "admin.race.row.html");
		
		$q->query("SELECT a.id, member_id, b.email, level1_ref, race_id FROM race_stats a, members b WHERE b.id=a.member_id AND a.race_id='$id'");
		$cont = 0;
		while($q->next_record()){
			$cont = 1;
			$t->set_var("link","members.php?action=search&search=id&criteria=".$q->f("member_id"));
			$t->set_var("id",$q->f("member_id"));
			$t->set_var("email",$q->f("email"));
			$t->set_var("nr_ref",$q->f("level1_ref"));
			$t->parse("statistics", "statistics_f", true);
	
		}
		if (!$cont){
			$t->set_var("statistics","");
		}
	
	include("inc.bottom.php");
?>