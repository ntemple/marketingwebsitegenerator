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
$months_arr = array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");
$t->set_file("content", "member.area.calendar.html");
$year = 2006;
if (!$month){
	$month = date("n");
}
$month_select = '';
for($j=1;$j<=count($months_arr);$j++){
	if ($month == $j){
		$month_select .= "<option value=\"$j\" id=\"$j\" selected>".$months_arr[$j]."</option>";
	}else{
		$month_select .= "<option value=\"$j\" id=\"$j\" >".$months_arr[$j]."</option>";
	}
}
$t->set_var("month_select",$month_select);
if (!$_GET['year']){
	$year = date("Y");
}else{
	$year = $_GET['year'];
}
$year_now = date("Y");
$year_select = '';
	for($j=2006;$j<=$year_now+2;$j++){
	if ($year == $j){
		$year_select .= "<option value=\"$j\" id=\"$j\" selected>".$j."</option>";
	}else{
		$year_select .= "<option value=\"$j\" id=\"$j\" >".$j."</option>";
	}
}
$t->set_var("year_select",$year_select);
$t->set_var("curr_year",$year);
$t->set_var("prev_month","<a href='member.area.calendar.php?year=".(($month-1) == 0 ? ($year-1) : $year)."&month=".(($month-1) == 0 ? '12' : $month-1)."'>".$months_arr[(($month-1) == 0 ? '12' : $month-1)]."</a>");
$t->set_var("curr_month",$months_arr[$month]);
$t->set_var("next_month","<a href='member.area.calendar.php?year=".(($month+1) == 13 ? ($year+1) : $year)."&month=".(($month+1) == 13 ? '1' : $month+1)."'>".$months_arr[(($month+1) == 13 ? '1' : $month+1)]."</a>");
$today = date("j.n.Y");
if (date("j.n.Y", mktime(0,0,0,$month,1,$year)) == $today){
	$first_of_month = true;
}else{
	$first_of_month = false;
}
if (date('l', mktime(0,0,0,$month,1,$year)) == "Sunday"){
	$t->set_var("z1",1);
	if ($first_of_month) $t->set_var("style1","style='background-color:#CCFF00'");
	$first = 1;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Monday"){
	$t->set_var("z2",1);
	if ($first_of_month) $t->set_var("style2","style='background-color:#CCFF00'");
	$first = 2;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Tuesday"){
	$t->set_var("z3",1);
	if ($first_of_month) $t->set_var("style3","style='background-color:#CCFF00'");
	$first = 3;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Wednesday"){
	$t->set_var("z4",1);
	if ($first_of_month) $t->set_var("style4","style='background-color:#CCFF00'");
	$first = 4;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Thursday"){
	$t->set_var("z5",1);
	if ($first_of_month) $t->set_var("style5","style='background-color:#CCFF00'");
	$first = 5;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Friday"){
	$t->set_var("z6",1);
	if ($first_of_month) $t->set_var("style6","style='background-color:#CCFF00'");
	$first = 6;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Saturday"){
	$t->set_var("z7",1);
	if ($first_of_month) $t->set_var("style7","style='background-color:#CCFF00'");
	$first = 7;
}
$month_end = cal_days_in_month(CAL_GREGORIAN,$month,$year);
preg_match("'(\d+)\.(\d+)\.(\d+)'",$today,$match);
if($match[2] == $month && $match[3] == $year) $current_date = true;
else $current_date = false;
for($i=$first+1;$i<$month_end+$first;$i++){
	if ($current_date && ($i-$first+1 == $match[1])){
		$t->set_var("style$i","style='background-color:#CCFF00'");
	}
	if($i > 35){
		$t->set_var("last_days","
		<tr>
			<td align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '').">".((++$i-1)<$month_end+$first ? $i-$first : '')."</td>
			<td align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '').">".((++$i-1)<$month_end+$first ? $i-$first : '')."</td>
			<td align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '').">".((++$i-1)<$month_end+$first ? $i-$first : '')."</td>
			<td align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '').">".((++$i-1)<$month_end+$first ? $i-$first : '')."</td>
			<td align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '').">".((++$i-1)<$month_end+$first ? $i-$first : '')."</td>
			<td align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '').">".((++$i-1)<$month_end+$first ? $i-$first : '')."</td>
			<td align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '').">".((++$i-1)<$month_end+$first ? $i-$first : '')."</td>
		</tr>"
	);
	}else{
		$t->set_var("z$i",$i-$first+1);
	}
}
include("inc.bottom.php");
?>
