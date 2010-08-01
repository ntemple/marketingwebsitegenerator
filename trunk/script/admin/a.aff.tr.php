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
	$q3=new Cdb;
	$cmember="";
  $script = '';
	FFileRead("templates/a.admin.template.aff.tr.htm",$cmember);
	$sta=$status;
	FFileRead("templates/a.admin.template.aff.tr.row.htm",$row);
	
	if ($month_end==''){ 
		if(isset($_SESSION['month_end'])) $month_end=$_SESSION['month_end'];
		else $month_end=date("n");
	}
	if ($day_start==''){ 
		if( isset($_SESSION['day_start'])) $day_start=$_SESSION['day_start'];
		else $day_start=date("j");
	}
	if ($day_end=='' ){ 
		if( isset($_SESSION['day_end'])) $day_end=$_SESSION['day_end'];
		else $day_end=date("j");
	}
	if ($year_start==''){ 
		if(  isset($_SESSION['year_start'])) $year_start=$_SESSION['year_start'];
		else $year_start=date("Y");
	}
	if ($year_end==''){ 
		if( isset($_SESSION['year_end'])) $year_end=$_SESSION['year_end'];
		else $year_end=date("Y",mktime(0,0,0,$month_end-1,$day_start,$year_start));
	}
	if ($month_start=='' ){ 
		if( isset($_SESSION['month_start'])) $month_start=$_SESSION['month_start'];
		else $month_start=date("n",mktime(0,0,0,$month_end-1,$day_start,$year_start));
	}
	if (isset($group)) $query="select count(*) as cs from a_tr where group_id='$group' and status='$status'";
	else $query="select count(*) as cs from a_tr where status='$status'";
	if($search!=''){
		$src="and buyer_id='".$search."'";
	}else if($search2!=''){
		$src="and member_id='".$search2."'";
	}
	if($time_trigger==1){
		$time_interval=" and dt>='".date("Y-m-d",mktime(0,0,0,$month_start,$day_start,$year_start))."' and dt<'".date("Y-m-d",mktime(0,0,0,$month_end,$day_end+1,$year_end))."'";
		$date_vars="&month_start=$month_start&day_start=$day_start&year_start=$year_start&month_end=$month_end&day_end=$day_end&year_end=$year_end&time_trigger=1";
		$script="<script>expand('date_1','plus')</script>";
		$query.=$time_interval;
	}else if($src!=''){
		$query.=$src;
	}
	$q->query($query);
	$q->next_record();
	$pages=$q->f("cs");
	$no_pages_raw=$pages/50;
	$no_pages_exp=explode(".",$no_pages_raw);
	if ($no_pages_exp[1]) {
		$no_pages=$no_pages_exp[0]+1;
	} else {
		$no_pages=$no_pages_raw;
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
	if (empty($page)) 
	{
		
		$page=1;
	}
	
	for ($i=1;$i<$no_pages+1;$i++){
	if (isset($group)) {
		if ($i==1 && $page!=1) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&group=".$group.$date_vars.">"."First"."</a>]";
		if ($i==1 && $page!=1 && $no_pages>1) {$prev=$page-1; $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page="."$prev"."&group=".$group.$date_vars.">"."<< Previous"."</a>]";}
		if ($i<=$no_pages-1 && $i!=1 && $i==$page-1) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&group=".$group.$date_vars.">"."$i"."</a>]";
		if ($i<=$no_pages-1 && $i!=1 && $i<$page-1 && $i>$page-6) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&group=".$group.$date_vars.">"."$i"."</a>]";
		if ($i==$page) $pagelist.="<b> $i </b>";
		if ($i<=$no_pages-1 && $i!=$no_pages && $i>$page+1 && $i<$page+6) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&group=".$group.$date_vars.">".$i."</a>]";
		if ($i<=$no_pages-1 && $i!=$no_pages && $i==$page+1) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&group=".$group.$date_vars.">".$i."</a>]";
		if ($i==$no_pages && $page!=$no_pages && $no_pages>1) {$next=$page+1; $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$next."&group=".$group.$date_vars.">"."Next >>"."</a>]";}
		if ($i==$no_pages && $page!=$no_pages) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&group=".$group.$date_vars.">"."Last"."</a>]";
			
	} else { 
		if ($i==1 && $page!=1) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i.">"."First"."</a>]";
		if ($i==1 && $page!=1 && $no_pages>1) {$prev=$page-1; $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page="."$prev"."&search=".$search."&search2=".$search2.$date_vars.">"."<< Previous"."</a>]";}
		if ($i<=$no_pages-1 && $i!=1 && $i==$page-1) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&search=".$search."&search2=".$search2.$date_vars.">"."$i"."</a>]";
		if ($i<=$no_pages-1 && $i!=1 && $i<$page-1 && $i>$page-6) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&search=".$search."&search2=".$search2.$date_vars.">".$i."</a>]";
		if ($i==$page) $pagelist.="<b> $i </b>";
		if ($i<=$no_pages-1 && $i!=$no_pages && $i>$page+1 && $i<$page+6) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&search=".$search."&search2=".$search2.$date_vars.">".$i."</a>]";
		if ($i<=$no_pages-1 && $i!=$no_pages && $i==$page+1) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&search=".$search."&search2=".$search2.$date_vars.">".$i."</a>]";
		if ($i==$no_pages && $page!=$no_pages && $no_pages>1) {$next=$page+1; $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$next."&search=".$search."&search2=".$search2.$date_vars.">"."Next >>"."</a>]";}
		if ($i==$no_pages && $page!=$no_pages) $pagelist.="[<a href=a.aff.tr.php?status=".$status."&page=".$i."&search=".$search."&search2=".$search2.$date_vars.">"."Last"."</a>]";
				
			}
	}
	$cmember=str_replace("{pagelist}", $pagelist, $cmember);
	$query="select * from a_tr where status='$status' $time_interval order by id  limit ".(($page-1)*50).",50";
	$i=0;
	if (isset($group))
	{
		$query="select * from a_tr where status='$status' $time_interval /* and group_id='$group'  */ order by id limit ".(($page-1)*50).",50";
	}
	if($search!=''){
		$query="select * from a_tr where buyer_id='".$search."' and status='$status' $time_interval order by id limit ".(($page-1)*50).",50";
	}else if($search2!=''){
		$query="select * from a_tr where member_id='".$search2."' and status='$status' $time_interval order by id limit ".(($page-1)*50).",50";
	}
	$q->query($query);
	if ($q->nf()==0)
		$rows="<tr><td colspan=3>NO TRANSACTIONS FOUND</td></tr>";
	else
	while ($q->next_record())
	{
		switch ($q->f("status"))
		{
			case 0: $st="Pending"; break;
			case 1: $st="Active"; break;
			case 2: $st="Past"; break;
			case 3: $st="Cancelled"; break;
		}
		
		$query="select * from members where id='".$q->f("member_id")."'";
		$q3->query($query);
		$q3->next_record();
		
		$rows.=str_replace("{id}",$q->f("id"),$row);
		$rows=str_replace("{currency}",get_setting('paypal_currency'),$rows);
		$rows=str_replace("{member_id}",$q->f("member_id"),$rows);
		$rows=str_replace("{group_id}",$q->f("group_id"),$rows);
		$rows=str_replace("{first_name}",$q3->f("first_name"),$rows);
		$rows=str_replace("{last_name}",$q3->f("last_name"),$rows);
		$rows=str_replace("{email}",$q3->f("paypal_email"),$rows);
		$rows=str_replace("{amount}",number_format($q->f("amount"),2),$rows);
		$rows=str_replace("{status}",$st,$rows);
		$rows=str_replace("{buyer_id}",$q->f("buyer_id"),$rows);
		$rows=str_replace("{dt}",$q->f("dt"),$rows);
		$rows=str_replace("{comments}",$q->f("comments"),$rows);
		$rows=str_replace("{admin_note}",$q->f("admin_note") !='' ?  $q->f("admin_note") : "&nbsp;" ,$rows);
	}
	if (isset($group)) $query="select sum(amount) as n from a_tr where status='$status' $time_interval and group_id='$group' ".($search>0 ? "and buyer_id='$search'" : "" );
	else $query="select sum(amount) as n from a_tr where status='$status' $time_interval ".($src!='' ? $src : "" );
	$q->query($query);
	$q->next_record();
	$cmember=str_replace("{total}",number_format($q->f("n"),2),$cmember);
	$cmember=str_replace("{currency}",get_setting('paypal_currency'),$cmember);
//	$cmember=str_replace("{id}",$sess _ id,$cmember);  sess.id is undefined here
	$cmember=str_replace("{rows}",$rows,$cmember);
	$cmember=str_replace("{action}",$action,$cmember);
	$cmember=str_replace("{sitename}",$sitename,$cmember);
	
  $main = $cmember;

  $main=str_replace("{status}",$status,$main);
  $main=str_replace("{search}",$search,$main);
  $main=str_replace("{search2}",$search2,$main);
    
  if($time_trigger==1)
    $main=str_replace("{time_interval}",$time_interval,$main);
  else 
    $main=str_replace("{time_interval}","",$main);

  if($month_start!='') $_SESSION['month_start']=$month_start;
  if($month_end!='') $_SESSION['month_end']=$month_end;
  if($day_start!='') $_SESSION['day_start']=$day_start;
  if($day_end!='') $_SESSION['day_end']=$day_end;
  if($year_start!='') $_SESSION['year_start']=$year_start;
  if($year_end!='') $_SESSION['year_end']=$year_end;

  
  
//	FFileRead("templates/admin.main.".$_SESSION['menu'].".html",$main);
//	FFileRead("../config/version", $version);
//	$query="select id from messages where member_id=1 and read_flag=0";
//	$q->query($query);
//	$q->next_record();
//	$main=str_replace("{version}", $version, $main);
//	$main=str_replace("{newmessages}",$q->nf(),$main);
//	$main=str_replace("{content}",$content,$main);
//	$main=str_replace("{status}",$sta,$main);
//	$main=str_replace("{title}",$title,$main);
//	$main=str_replace("{sitename}",$sitename,$main);
//	$main=str_replace("{webmasteremail}",$webmasteremail,$main);
//	$main=str_replace("{year}", date("Y"),$main);

 // @todo: refactor aff.tr.php to use templating system	
//  if (isset($_GET['menu'])) {
//    $_SESSION['menu'] = $_GET['menu'];
//  }
  
  print mwg_admin_decorate($main, '', '', $script);
  
//  genstall_admin_end($t, $main.$script, $notemplate);  
?>
