<?php 
	include("inc.top.php");
	$q=new Cdb;
	
	$q3=new Cdb;
	$cmember="";
	FFileRead("../templates/a.admin.template.aff.members.htm",$cmember);
	$sta=$status;
	if (isset($_SESSION['month_end'])) $month_end=$_SESSION['month_end'];
	else $month_end=date("n");
	if (isset($_SESSION['day_start'])) $day_start=$_SESSION['day_start'];
	else $day_start=date("j");
	if (isset($_SESSION['day_end'])) $day_end=$_SESSION['day_end'];
	else $day_end=date("j");
	if (isset($_SESSION['year_start'])) $year_start=$_SESSION['year_start'];
	else $year_start=date("Y");
	if (isset($_SESSION['year_end'])) $year_end=$_SESSION['year_end'];
	else $year_end=date("Y",mktime(0,0,0,$month_end-1,$day_start,$year_start));
	if (isset($_SESSION['month_start'])) $month_start=$_SESSION['month_start'];
	else $month_start=date("n",mktime(0,0,0,$month_end-1,$day_start,$year_start));
	FFileRead("../templates/a.admin.template.aff.members.row.htm",$row);
	
if($time_trigger==1){
		$time_interval=" and dt>='".date("Y-m-d",mktime(0,0,0,$month_start,$day_start,$year_start))."' and dt<'".date("Y-m-d",mktime(0,0,0,$month_end,$day_end+1,$year_end))."'";
		$date_vars="&month_start=$month_start&day_start=$day_start&year_start=$year_start&month_end=$month_end&day_end=$day_end&year_end=$year_end&time_trigger=1";
		$script="<script>expand('date_1','plus')</script>";
	}
	for ($i=1;$i<=31;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			if (!$day_start) $day_start_sel .= "<option value='$i' name='".$k."' ".($i == date("j") ? "selected" : "").">$i</option>";
			else $day_start_sel .= "<option value='$i' name='".$k."' ".($i == $day_start ? "selected" : "").">$i</option>";
		}
		
		for ($i=1;$i<=12;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			if (!$month_start) $month_start_sel .= "<option value='$i' name='".$k."' ".($i == date("n")-1 ? "selected" : "").">$i</option>";
			else $month_start_sel .= "<option value='$i' name='".$k."' ".($i == $month_start ? "selected" : "").">$i</option>";
		}
		
		$j = 0;
		for ($i=2006;$i<=2020;$i++){
			if (!$year_start) $year_start_sel .= "<option value='$i' name='$j' ".($i == date("Y") ? "selected" : "").">$i</option>";
			else $year_start_sel .= "<option value='$i' name='".$k."' ".($i == $year_start ? "selected" : "").">$i</option>";
			$j++;
		}
		for ($i=1;$i<=31;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			if (!$day_end) $day_end_sel .= "<option value='$i' name='".$k."' ".($i == date("j") ? "selected" : "").">$i</option>";
			else $day_end_sel .= "<option value='$i' name='".$k."' ".($i == $day_end ? "selected" : "").">$i</option>";
		}	
		for ($i=1;$i<=12;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			if (!$month_end) $month_end_sel .= "<option value='$i' name='".$k."' ".($i == date("n") ? "selected" : "").">$i</option>";
			else $month_end_sel .= "<option value='$i' name='".$k."' ".($i == $month_end ? "selected" : "").">$i</option>";
		}
		$j = 0;
		for ($i=2006;$i<=2020;$i++){
			if (!$year_end) $year_end_sel .= "<option value='$i' name='$j' ".($i == date("Y") ? "selected" : "").">$i</option>";
			else $year_end_sel .= "<option value='$i' name='".$k."' ".($i == $year_end ? "selected" : "").">$i</option>";
			$j++;
		}
	$cmember=str_replace("{day_start}",$day_start_sel,$cmember);
	$cmember=str_replace("{month_start}",$month_start_sel,$cmember);
	$cmember=str_replace("{year_start}",$year_start_sel,$cmember);
	$cmember=str_replace("{day_end}",$day_end_sel,$cmember);
	$cmember=str_replace("{month_end}",$month_end_sel,$cmember);
	$cmember=str_replace("{year_end}",$year_end_sel,$cmember);
	$cmember=str_replace("{d_start}",$day_start,$cmember);
	$cmember=str_replace("{m_start}",$month_start,$cmember);
	$cmember=str_replace("{y_start}",$year_start,$cmember);
	$cmember=str_replace("{d_end}",$day_end,$cmember);
	$cmember=str_replace("{m_end}",$month_end,$cmember);
	$cmember=str_replace("{y_end}",$year_end,$cmember);
	$query="select distinct member_id from a_tr order by member_id";
	$q->query($query);
	while ($q->next_record())
	{
 		$st="";
		
 		$query="select sum(amount) as n from a_tr where member_id='".$q->f("member_id")."' and status=1 ".$time_interval;
		$q3->query($query);
		$q3->next_record();
		if ($q3->f("n")>0)
		{
			$rows.=str_replace("{id}",$q->f("member_id"),$row);
			$rows=str_replace("{member_id}",$q->f("member_id"),$rows);
			$total+=$q3->f("n");
			
			$rows=str_replace("{amount}",number_format($q3->f("n"),2),$rows);
			
			$query="select * from members where id='".$q->f("member_id")."'";
			$q3->query($query);
			$q3->next_record();
IF ($q3->f("paypal_email") !='') {
			$rows=str_replace("{paypal_email}",$q3->f("paypal_email"),$rows);
			$rows=str_replace("{email}","",$rows);
} ELSE {
  $rows=str_replace("{email}",$q3->f("email"),$rows);
  $rows=str_replace("{paypal_email}","",$rows);
}
			$rows=str_replace("{first_name}",$q3->f("first_name"),$rows);
			$rows=str_replace("{last_name}",$q3->f("last_name"),$rows);
			$rows=str_replace("{currency}",get_setting('paypal_currency'),$rows);
	
		}
	}
	
	$cmember=str_replace("{total}",$total,$cmember);
	$cmember=str_replace("{rows}",$rows,$cmember);
	$cmember=str_replace("{currency}",get_setting('paypal_currency'),$cmember);
	$cmember=str_replace("{action}",$action,$cmember);
	$cmember=str_replace("{sitename}",$sitename,$cmember);
	$content=$cmember;
	FFileRead("../templates/admin.main.".$_SESSION['menu'].".html",$main);
	FFileRead("../config/version", $version);
	$query="select id from messages where member_id=1 and read_flag=0";
	$q->query($query);
	$q->next_record();
	$main=str_replace("{version}", $version, $main);
	$main=str_replace("{newmessages}",$q->nf(),$main);
	$main=str_replace("{content}",$content,$main);
	$main=str_replace("{status}",$sta,$main);
	$main=str_replace("{title}",$title,$main);
	$main=str_replace("{sitename}",$sitename,$main);
	$main=str_replace("{year}",date("Y"),$main);
	$main=str_replace("{webmasteremail}",$webmasteremail,$main);
	if($time_trigger==1)
		$main=str_replace("{time_interval}",$time_interval,$main);
	else 
		$main=str_replace("{time_interval}","",$main);
	if($month_start!='') $_SESSION['month_start']=$month_start;
	if($month_end=='') $_SESSION['month_end']=$month_end;
	if($day_start=='') $_SESSION['day_start']=$day_start;
	if($day_end=='') $_SESSION['day_end']=$day_end;
	if($year_start=='') $_SESSION['year_start']=$year_start;
	if($year_end=='') $_SESSION['year_end']=$year_end;
	echo $main.$script;
?>
