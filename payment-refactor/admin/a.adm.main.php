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
	FFileRead("templates/a.admin.template.main.htm",$content);
	
	if ($_SESSION['menu'] == ""){
		$_SESSION['menu'] = "settings";
	}elseif ($menu == "members"){
			$_SESSION['menu'] = "members";
	}elseif ($_GET['menu'] == "design"){
			$_SESSION['menu'] = "design";
	}elseif ($_GET['menu'] == "membership"){
			$_SESSION['menu'] = "membership";
	}elseif ($_GET['menu'] == "help"){
			$_SESSION['menu'] = "help";
	}elseif ($_GET['menu'] == "updates"){
			$_SESSION['menu'] = "updates";
	}
	if($time_trigger!=1){
		if($month_start=='') $month_start=date("n")-1;
		if($month_end=='') $month_end=date("n");
		if($day_start=='') $day_start=date("j");
		if($day_end=='') $day_end=date("j");
		if($year_start=='') $year_start=date("Y");
		if($year_end=='') $year_end=date("Y",mktime(0,0,0,$month_end-1,$day_start,$year_start));
		$content=str_replace("{display}","none", $content);
	}else{
		$time_interval=" and dt>='".date("Y-m-d",mktime(0,0,0,$month_start,$day_start,$year_start))."' and dt<'".date("Y-m-d",mktime(0,0,0,$month_end,$day_end+1,$year_end))."'";
		$q->query("SELECT sum(amount) as s FROM a_tr WHERE status=0 and member_id!='0'  $time_interval");
		$q->next_record();
		$content=str_replace("{amount0}", $q->f("s")>0?number_format($q->f("s"),2) : "0.00", $content);
		$q->query("SELECT sum(amount) as s FROM a_tr WHERE status=1  and member_id!='0'  $time_interval");
		$q->next_record();
		$content=str_replace("{amount1}", $q->f("s")>0?number_format($q->f("s"),2) : "0.00", $content);
		$q->query("SELECT sum(amount) as s FROM a_tr WHERE status=2  and member_id!='0'  $time_interval");
		$q->next_record();
		$content=str_replace("{amount2}", $q->f("s")>0?number_format($q->f("s"),2) : "0.00", $content);
		
		$q->query("SELECT sum(amount) as s FROM a_tr WHERE status=0   and member_id='0'  $time_interval");
		$q->next_record();
		$content=str_replace("{amount3}", $q->f("s")>0?number_format($q->f("s"),2) : "0.00", $content);
		$q->query("SELECT sum(amount) as s FROM a_tr WHERE status=1  and member_id='0'  $time_interval");
		$q->next_record();
		$content=str_replace("{amount4}", $q->f("s")>0?number_format($q->f("s"),2) : "0.00", $content);
		$q->query("SELECT sum(amount) as s FROM a_tr WHERE status=2  and member_id='0'  $time_interval");
		$q->next_record();
		$content=str_replace("{amount5}", $q->f("s")>0?number_format($q->f("s"),2) : "0.00", $content);
		$content=str_replace("{display}","", $content);
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
	$content=str_replace("{day_start}",$day_start_sel,$content);
	$content=str_replace("{month_start}",$month_start_sel,$content);
	$content=str_replace("{year_start}",$year_start_sel,$content);
	$content=str_replace("{day_end}",$day_end_sel,$content);
	$content=str_replace("{month_end}",$month_end_sel,$content);
	$content=str_replace("{year_end}",$year_end_sel,$content);
	FFileRead("templates/admin.main.".$_SESSION['menu'].".html",$main);
	FFileRead("../config/version", $version);
	$query="select id from messages where member_id=1 and read_flag=0";
	$q->query($query);
	$q->next_record();
	$main=str_replace("{version}", $version, $main);
	$main=str_replace("{content}",$content,$main);
	$main=str_replace("{newmessages}",$q->nf(),$main);
	$main=str_replace("{title}",$title,$main);
	$main=str_replace("{sitename}",$sitename,$main);
	$main=str_replace("{webmasteremail}",$webmasteremail,$main);
	$main=str_replace("{year}", date("Y"),$main);
	echo $main;
?>
