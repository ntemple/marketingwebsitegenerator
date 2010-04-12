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
	 get_logged_info();
	 $q2=new CDB;
	 $query="SELECT id FROM menus WHERE link='member.area.notes.php'";
	 $q2->query($query);
	 $q2->next_record();
	 $query="SELECT membership_id FROM menu_permissions WHERE menu_item='".$q2->f("id")."'";
	 $q2->query($query);
	 while ($q2->next_record()) {
	 	$permissions[]=$q2->f("membership_id");
	 }
	 if (count($permissions)>0) {
	 	$error='<center><font color="red"><b>You do not have access to this area!<br><br>Upgrade your membership level!</b></font></center>';
	 	foreach ($permissions as $value) {
	 		if ($value==$q->f("membership_id")) {
	 			$error='';
	 			break;
	 		}
		}
		if ($error!="") {
			die("$error");
		}
	 }
$member_id=$q->f("id");
$t->set_file("content", "member_notes.html");
$t->set_file("notes_list", "member_notes_item.html");
if (!$day){
	$day = date("j");
	$day_d = date("d");
}elseif (strlen($day) == 1){
	$day_d = "0".$day;
}else{
	$day_d = $day;
}
$t->set_var('day',$day);
$months_arr = array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");
if (!$month){
	$month = date("n");
	$month_d = date('m');
}elseif (strlen($month) == 1){
	$month_d = "0".$month;
}else{
	$month_d = $month;
}
$t->set_var('month',$month);
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
$t->set_var('year',$year);
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
$t->set_var("prev_month","<a href='member.area.notes.php?year=".(($month-1) == 0 ? ($year-1) : $year)."&month=".(($month-1) == 0 ? '12' : $month-1)."&day=$day'>&lt;&lt; ".$months_arr[(($month-1) == 0 ? '12' : $month-1)]."</a>");
$t->set_var("curr_month",$months_arr[$month]);
$t->set_var("next_month","<a href='member.area.notes.php?year=".(($month+1) == 13 ? ($year+1) : $year)."&month=".(($month+1) == 13 ? '1' : $month+1)."&day=$day'>".$months_arr[(($month+1) == 13 ? '1' : $month+1)]." &gt;&gt;</a>");
$today = date("j.n.Y");
if (date("j.n.Y", mktime(0,0,0,$month,1,$year)) == $today){
	$first_of_month = true;
}else{
	$first_of_month = false;
}
$t->set_var('notes_add',"year=$year&month=$month&day=$day");
$query="select * from member_journal where member_id='$member_id' AND date='$year-$month_d-$day' order by id desc";
$q->query($query);
while ($q->next_record())
{
	$t->set_var("subject", $q->f("subject"));
	$t->set_var("date", $q->f("date"));
	$t->set_var("body", $q->f("body"));
	$t->set_var("note_id", $q->f("id"));
	$t->parse("notes", "notes_list", true);
}
$first = 0;
if (date('l', mktime(0,0,0,$month,1,$year)) == "Sunday"){
	$t->set_var("z1",1);
	if ($first_of_month) $t->set_var("bckg_color1","background-color:#CCFF00'");
	if ($day == 1){
		$t->set_var("bckg_color1","background-color:#0033FF'");
		$t->set_var("link_color1","color:#FFFFFF");
	}
	$first = 1;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Monday"){
	$t->set_var("z2",1);
	if ($first_of_month) $t->set_var("bckg_color2","background-color:#CCFF00");
	if ($day == 1){
		$t->set_var("bckg_color2","background-color:#0033FF'");
		$t->set_var("link_color2","color:#FFFFFF");
	}
	$first = 2;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Tuesday"){
	$t->set_var("z3",1);
	if ($first_of_month) $t->set_var("bckg_color3","background-color:#CCFF00");
	if ($day == 1){
		$t->set_var("bckg_color3","background-color:#0033FF'");
		$t->set_var("link_color3","color:#FFFFFF");
	}
	$first = 3;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Wednesday"){
	$t->set_var("z4",1);
	if ($first_of_month) $t->set_var("bckg_color4","background-color:#CCFF00");
	if ($day == 1){
		$t->set_var("bckg_color4","background-color:#0033FF'");
		$t->set_var("link_color4","color:#FFFFFF");
	}
	$first = 4;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Thursday"){
	$t->set_var("z5",1);
	if ($first_of_month) $t->set_var("bckg_color5","background-color:#CCFF00");
	if ($day == 1){
		$t->set_var("bckg_color5","background-color:#0033FF'");
		$t->set_var("link_color5","color:#FFFFFF");
	}
	$first = 5;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Friday"){
	$t->set_var("z6",1);
	if ($first_of_month) $t->set_var("bckg_color6","background-color:#CCFF00");
	if ($day == 1){
		$t->set_var("bckg_color6","background-color:#0033FF'");
		$t->set_var("link_color6","color:#FFFFFF");
	}
	$first = 6;
}elseif (date('l', mktime(0,0,0,$month,1,$year)) == "Saturday"){
	$t->set_var("z7",1);
	if ($first_of_month) $t->set_var("bckg_color7","background-color:#CCFF00");
	if ($day == 1){
		$t->set_var("bckg_color7","background-color:#0033FF'");
		$t->set_var("link_color7","color:#FFFFFF");
	}
	$first = 7;
}
$q2->query("SELECT * from member_journal where member_id='$member_id' AND date='$year-$month_d-1' order by id desc");
if ($first && $first_of_month){
	$t->set_var("curr_day_tag",$first);
	$t->set_var("set_day_tag",$first);
}
$j = 0;
$title_str = '';
while ($q2->next_record()){
	$j++;
	$title_str = $q2->f("subject");
}
if ($j > 1){
		$t->set_var("div","<div
						  id='PopupDiv$first'
						  style='position:absolute; top:25px; left:50px; padding:4px; display:none; background-color:#000000; color:#ffffff; z-index:100>
						  "."There are $j notes on this day. Click to view them"."
						 </div>
						",true);
	$t->set_var("true$first","DivSetVisible(true,$first)");
	$t->set_var("false$first","DivSetVisible(false,$first)");
	$t->set_var("font$i","font-weight:bolder;font-style:oblique;font-size:12px;");
}elseif ($j != 0){
		$t->set_var("div","<div
						  id='PopupDiv$first'
						  style='position:absolute; top:25px; left:50px; padding:4px; display:none; background-color:#000000; color:#ffffff; z-index:100''>
						  $title_str
						 </div>
						",true);
	$t->set_var("true$first","DivSetVisible(true,$first)");
	$t->set_var("false$first","DivSetVisible(false,$first)");
	$t->set_var("font$first","font-weight:bolder;font-style:oblique;font-size:12px;");
}else{
	$t->set_var("false$first","");
	$t->set_var("true$first","");
}
$month_end = cal_days_in_month(CAL_GREGORIAN,$month,$year);
preg_match("'(\d+)\.(\d+)\.(\d+)'",$today,$match);
if($match[2] == $month && $match[3] == $year) $current_date = true;
else $current_date = false;
$notes_arr = array();
for($i=$first+1;$i<$month_end+$first;$i++){
	$q2->query("SELECT * from member_journal where member_id='$member_id' AND date='$year-$month_d-".($i-$first+1)."' order by id desc");
	
	$j = 0;
	$title_str = '';
	while ($q2->next_record()){
		$j++;
		$title_str = $q2->f("subject");
	}
	if ($j > 1){
		$t->set_var("div","<div
						  id='PopupDiv$i'
						  style='position:absolute; top:25px; left:50px; padding:4px; display:none; background-color:#ffffff; color:#000000; z-index:100; border:solid; border-color:#CCCCCC; border-width:thin'>
						  "."There are $j notes on this day. Click to view them"."
						 </div>
						",true);
		$t->set_var("true$i","DivSetVisible(true,$i)");
		$t->set_var("false$i","DivSetVisible(false,$i)");
		$t->set_var("font$i","font-weight:bolder;font-style:oblique;font-size:12px;");
	}elseif ($j != 0){
		$t->set_var("div","<div
						  id='PopupDiv$i'
						  style='position:absolute; top:25px; left:50px; padding:4px; display:none; background-color:#ffffff; color:#000000; z-index:100; border:solid; border-color:#CCCCCC; border-width:thin'>
						  $title_str
						 </div>
						",true);
		$t->set_var("true$i","DivSetVisible(true,$i)");
		$t->set_var("false$i","DivSetVisible(false,$i)");
		$t->set_var("font$i","font-weight:bolder;font-style:oblique;font-size:12px;");
	}else{
		$t->set_var("false$i","");
		$t->set_var("true$i","");
	}
	
	if ($i-$first+1 == $day){
		$t->set_var("bckg_color$i","background-color:#0033FF;");
		$t->set_var("link_color$i","color:#FFFFFF");
		if ($day == date("j")){ $t->set_var("curr_day_tag",$i); $t->set_var("set_day_tag",$i);}
		else{ $t->set_var("curr_day_tag",$i); $t->set_var("set_day_tag",$i);}
	}elseif ($current_date && ($i-$first+1 == $match[1])){
		$t->set_var("bckg_color$i","background-color:#CCFF00;");
		$t->set_var("curr_day_tag",$i);
		$t->set_var("set_day_tag",$i);
	}
	if($i > 35){
		$t->set_var("last_days","
		<tr>
			<td id='td36' align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '')." onmouseover=\"mouse_over('td36')\" onmouseout=\"mouse_out('td36')\" onclick=\"if (document.getElementById('link36').text!='') window.location='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'\"><a id='link36' href='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'>".(($i-1)<$month_end+$first ? $i-$first : '')."</a></td>
			<td id='td37' align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '')." onmouseover=\"mouse_over('td37')\" onmouseout=\"mouse_out('td37')\" onclick=\"if (document.getElementById('link37').text!='') window.location='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'\"><a id='link37' href='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'>".(($i-1)<$month_end+$first ? $i-$first : '')."</a></td>
			<td id='td38' align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '')." onmouseover=\"mouse_over('td38')\" onmouseout=\"mouse_out('td38')\" onclick=\"if (document.getElementById('link38').text!='') window.location='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'\"><a id='link38' href='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'>".(($i-1)<$month_end+$first ? $i-$first : '')."</a></td>
			<td id='td39' align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '')." onmouseover=\"mouse_over('td39')\" onmouseout=\"mouse_out('td39')\" onclick=\"if (document.getElementById('link39').text!='') window.location='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'\"><a id='link39' href='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'>".(($i-1)<$month_end+$first ? $i-$first : '')."</a></td>
			<td id='td40' align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '')." onmouseover=\"mouse_over('td40')\" onmouseout=\"mouse_out('td40')\" onclick=\"if (document.getElementById('link40').text!='') window.location='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'\"><a id='link40' href='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'>".(($i-1)<$month_end+$first ? $i-$first : '')."</a></td>
			<td id='td41' align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '')." onmouseover=\"mouse_over('td41')\" onmouseout=\"mouse_out('td41')\" onclick=\"if (document.getElementById('link41').text!='') window.location='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'\"><a id='link41' href='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'>".(($i-1)<$month_end+$first ? $i-$first : '')."</a></td>
			<td id='td42' align='center' ".($current_date && ($i-$first+1 == $match[1]) ? "style='background-color:#CCFF00'" : '')." onmouseover=\"mouse_over('td42')\" onmouseout=\"mouse_out('td42')\" onclick=\"if (document.getElementById('link42').text!='') window.location='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'\"><a id='link42' href='member.area.notes.php?year=$year&month=$month&day=".((++$i-1)<$month_end+$first ? $i-$first : '')."'>".(($i-1)<$month_end+$first ? $i-$first : '')."</a></td>
		</tr>"
		);
	}else{
		$t->set_var("z$i",$i-$first+1);
	}
}
	
include("inc.bottom.php");
?>