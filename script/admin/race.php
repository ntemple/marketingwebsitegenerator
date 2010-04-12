<?php 
	include("inc.top.php");
	$t->set_file("content", "admin.race.html");
	
	$t->set_file("statistics_f", "admin.race.row.html");
	$t->set_file("pastraces", "admin.race.past.html");
	$q->query("SELECT MAX(id) AS max FROM race_details");
	$q->next_record();
	$race_id = $q->f("max");
	$q2=new Cdb;
	$q2->query("SELECT id, start, end_type, date_end, ref_end, enable FROM race_details WHERE id='$race_id'");
	$q2->next_record();
	$buton = "";
	
	$day_start_sel = '';
	$month_start_sel = '';
	$year_start_sel = '';
		
	if ($q2->f("enable")){
		$buton .= '<input type="submit" name="end" value="End Race Now" onclick="return confirm('."'Are you sure you want to end race ?'".')"/>';
		$buton .= '<input type="submit" name="'.($q2->f("enable") == 2 ? "resume" : "pause").'" value="'.($q2->f("enable") == 2 ? "Resume" : "Pause").' Race Now" onclick="return confirm('."'Are you sure you want to ".($q2->f("enable") == 2 ? "Resume" : "Pause")." race ?'".')"/>';
		$t->set_var("race_status",$q2->f("enable") == 2 ? "PAUSED" : "STARTED");
		
		$start_day = substr($q2->f("start"),8,2);
		$start_month = substr($q2->f("start"),5,2);
		$start_year = substr($q2->f("start"),0,4);
		
		for ($i=1;$i<=31;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$day_start_sel .= "<option value='$i' name='".$k."' ".($i == $start_day ? "selected" : "").">$i</option>";
		}
		
		for ($i=1;$i<=12;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$month_start_sel .= "<option value='$i' name='".$k."' ".($i == $start_month ? "selected" : "").">$i</option>";
		}
		
		$j = 0;
		for ($i=2006;$i<=2020;$i++){
			$year_start_sel .= "<option value='$i' name='$j' ".($i == $start_year ? "selected" : "").">$i</option>";
			$j++;
		}
		
		$end_day = substr($q2->f("date_end"),8,2);
		$end_month = substr($q2->f("date_end"),5,2);
		$end_year = substr($q2->f("date_end"),0,4);
		
		for ($i=1;$i<=31;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$day_end_sel .= "<option value='$i' name='".$k."' ".(($i == $end_day && $q2->f("end_type") == 1) ? "selected" : (($i == date("d")+1 && $q2->f("end_type") != 1) ? "selected" : "")).">$i</option>";
		}
		
		for ($i=1;$i<=12;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$month_end_sel .= "<option value='$i' name='".$k."' ".(($i == $end_month && $q2->f("end_type") == 1) ? "selected" : (($i == date("m") && $q2->f("end_type") != 1) ? "selected" : "")).">$i</option>";
		}
		
		$j = 0;
		for ($i=2006;$i<=2020;$i++){
			$year_end_sel .= "<option value='$i' name='$j' ".(($i == $end_year && $q2->f("end_type") == 1) ? "selected" : (($i == date("Y") && $q2->f("end_type") != 1) ? "selected" : "")).">$i</option>";
			$j++;
		}
		if ($q2->f("end_type") == 1){
			$t->set_var("ref_end","0");
			$t->set_var("end_chck_1","checked");
			$t->set_var("end_chck_2","");
		}elseif ($q2->f("end_type") == 2){
			$t->set_var("end_chck_1","");
			$t->set_var("end_chck_2","checked");
			$t->set_var("ref_end",$q2->f("ref_end"));
		}
		if ($_GET['no_ref'] == 1){
			$where_ref = '';
			$t->set_var("chck_ref",'checked');
		}else{
			$where_ref = ' AND level1_ref!=0 ';
		}
		$q->query("SELECT a.id, member_id, b.email, level1_ref, race_id FROM race_stats a, members b WHERE b.id=a.member_id $where_ref AND a.race_id='$race_id' GROUP BY member_id ORDER BY level1_ref DESC limit ".(!$page ? 1*30-30 : $page*30-30).",30");
		$cont = 0;
		
		$total=$q->nf();
	
		if (!isset($page)) $page=1;
	
		$perpage = 2;
		$total_pages=(int)($total/$perpage);
	
		if ($total%$perpage!=0) $total_pages++;
		$vars="&no_ref=$no_ref";
	
		if ($total_pages > $page) $next="<a href='race.php?page=".($page+1).$vars."'>Next >></a>";
	
		else $next=" Next >>";
		if ($page>1) $prev="<a href='race.php?page=".($page-1).$vars."'><< Prev</a>";
		else $prev="<< Prev";
		$prev_next=$prev." ".$next;
	$t->set_var("p".$perpage, "selected");
	$t->set_var("next_prev", $prev_next);
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
	
	}else{
		$buton .= "<input type='submit' name='start' value='Start Race Now' />";
		$t->set_var("race_status","STOPPED");
		$t->set_var("statistics","");
	
		$t->set_var("end_chck_1","checked");
		$t->set_var("end_chck_2","");
		
		$t->set_var("next_prev","");
		for ($i=1;$i<=31;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$day_start_sel .= "<option value='$i' name='".$k."' ".($i == date("d") ? "selected" : "").">$i</option>";
		}
		
		for ($i=1;$i<=12;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$month_start_sel .= "<option value='$i' name='".$k."' ".($i == date("m") ? "selected" : "").">$i</option>";
		}
		
		$j = 0;
		for ($i=2006;$i<=2020;$i++){
			$year_start_sel .= "<option value='$i' name='$j' ".($i == date("Y") ? "selected" : "").">$i</option>";
			$j++;
		}
		for ($i=1;$i<=31;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$day_end_sel .= "<option value='$i' name='".$k."' ".($i == date("d")+1 ? "selected" : "").">$i</option>";
		}
		
		for ($i=1;$i<=12;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			$month_end_sel .= "<option value='$i' name='".$k."' ".($i == date("m") ? "selected" : "").">$i</option>";
		}
		
		$j = 0;
		for ($i=2006;$i<=2020;$i++){
			$year_end_sel .= "<option value='$i' name='$j' ".($i == date("Y") ? "selected" : "").">$i</option>";
			$j++;
		}
		$t->set_var("ref_end","0");
	}
		
	$t->set_var("race_control_button",$buton);
	
	$t->set_var("day_start",$day_start_sel);
	$t->set_var("month_start",$month_start_sel);
	$t->set_var("year_start",$year_start_sel);
	
	$t->set_var("day_end",$day_end_sel);
	$t->set_var("month_end",$month_end_sel);
	$t->set_var("year_end",$year_end_sel);
	$query="select * from race_details where enable=0";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("contest_id", $q->f("id"));
		$t->set_var("contest_dates", $q->f("start")."/".$q->f("date_end"));
		$query="select * from race_stats where race_id='".$q->f("id")."' order by level1_ref desc limit 0,1";
		$q2->query($query);
		$q2->next_record();
		$member_id=$q2->f("member_id");
		$refs=$q2->f("level1_ref");
		$query="select first_name, last_name from members where id='$member_id'";
		$q2->query($query);
		$q2->next_record();
		$t->set_var("contest_won_by", $q2->f("first_name")." ".$q2->f("last_name")." with ".$refs." referrals");
		$t->parse("past_races", "pastraces", true);
	}
	if ($q->nf()==0) $t->set_var("past_races", "<tr><td colspan=3>No past races found</td></tr>");
	include("inc.bottom.php");
?>