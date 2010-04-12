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
	$q2=new cdb;
	$q3=new cdb;
	$chck_funtions = '';
	$t->set_file("content", "admin.cycler.stats.html");
	$t->set_file("cyclelist", "admin.cycle.graph.html");
	$values_stats = array();
	$width=50;
	$width_col=40;
	$height=200;
$curent_camp='';
$files=array('index.php','signup.php','oto.php','oto_bck.php','oto2.php','oto2_bck.php','salespage.php');
$stats.='<form name="stats" id="stats action="cycler_stats.php" method="GET">
			The file for which the stats to be shown :
			<select name="file" id="file" onChange="document.stats.campa.value=\'All Campaigns\' ;document.stats.submit();">
				  <option value="index.php" {index.php}>Index</option>
				  <option value="signup.php" {signup.php}>Signup</option>
				  <option value="oto.php" {oto.php}>Oto 1</option>
				  <option value="oto_bck.php" {oto_bck.php}>Oto Downsell</option>
				  <option value="oto2.php" {oto2.php}>Oto 2</option>
				  <option value="oto2_bck.php" {oto2_bck.php}>Oto 2 Downsell</option>
				  <option value="salespage.php" {salespage.php}>Salespage</option>
				  </select>';
	  
$file=$_GET['file'];
if (!$file) $file="index.php";
$sel=$_GET['sel'];
foreach ($files as $file_val){
	if ($file_val==$file) $stats=str_replace("{".$file_val."}","selected",$stats);
		else $stats=str_replace("{".$file_val."}","",$stats);
	
}
$stats.='<br> Select campaign : <select name="campa" id="campa" style="width:150px" onChange="document.stats.submit();">';
if ($_GET['campa']=="All Campaigns") $sel="selected";
if (!$_GET['campa']) $sel="selected";
$stats.=' <option value="All Campaigns"'.$sel.'>All Campaigns</option>';
$q->query("SELECT * FROM cycle WHERE file='".$file."' GROUP BY cycle"); 
if (isset($_GET['campa'])) $current_camp=$_GET['campa'];
	else $current_camp="All Campaigns";
while ($q->next_record()) {
	$sel="";
	if (isset($_GET['campa']) && $q->f("cycle")==$_GET['campa']) $sel="selected";
	$stats.=' <option value="'.$q->f("cycle").'"'.$sel.'>'.$q->f("cycle").'</option>'; 
	}
$stats.='</select></form>';
$t->set_var("cycler_stats",$stats);
if ($current_camp=="All Campaigns") {
	$stats.= 'ALL Campaigns <br>';
	$and="";
	}
	else {
		$and=" AND cycle='".$current_camp."'";
    	}
$q2->query("SELECT * FROM cycle WHERE file='".$file."'".$and." GROUP BY cycle");
if ($q2->nf()!='')
	while ($q2->next_record()){
		
		$stats= '<br>Campaign '.$q2->f("cycle");
		$q->query("SELECT * FROM cycle_stats WHERE value LIKE '%".$q2->f("cycle")."%'");
	
		$stats.='&nbsp;&nbsp;Views '.$q->nf();
		$stats.= '<br><br><font size=-5><strong>Conversion Rate </font></strong>';
		$t->set_var("view",$stats);
		
		$graph='<table align="left" valign="bottom" cellpadding="0" cellspacing="0" width="{size}"><tr>';
		$q->query("SELECT * FROM cycle WHERE cycle='".$q2->f("cycle")."'");
		while ($q->next_record()){
			$values[]=$q->f("text");
			$ids[]=$q->f("id");
		}
		$win_percent=0;
		$win_id=0;
		$win_camp='';
		foreach ($ids as $id){
			$q->query("SELECT * FROM cycle_stats WHERE value LIKE '%".$q2->f("cycle").":".$id."%'");
			$q->next_record();
			$values_nr=$q->nf();
			$q->query("SELECT * FROM cycle_stats WHERE value LIKE '%".$q2->f("cycle").":".$id."%' AND used=1");
			$q->next_record();
			$values_used=$q->nf();
			($values_nr==0  ?  $percent="0.00" : $percent=number_format($values_used*100/$values_nr,2) );
			if ($percent >= $win_percent){ 
				$win_percent = $percent;
				$win_id = $id;
				$win_camp = $q2->f("cycle");
			}
			$graph.='<td width="'.$width.'" height='.$height.' valign="bottom" align="center">
			'.$percent.'%<br>('.$values_nr."/".$values_used.')<br><img  src="../images/dot.GIF" height='.ceil($percent*$height/100).' width='.$width_col.'></td>';
			$count++;
			
		}
		
		if (strstr(get_setting("make_winner"),$q2->f("cycle")))
			$button='<br><form action=do.delete.winner.php method="POST">
				<input type="hidden" name="camp" value="'.$win_camp.'">
				<input type="hidden" name="id" value="'.$win_id.'">
				<input type="submit" name="makewin" id="makewin" value="Cancel Winner" ></form>';
			else
			$button='<br><form action=do.make.winner.php method="POST">
				<input type="hidden" name="camp" value="'.$win_camp.'">
				<input type="hidden" name="id" value="'.$win_id.'">
				<input type="submit" name="makewin" id="makewin" value="Make Winner" ></form>';
		$i=0;
		$size=$width*($count);
		$graph.='</tr></table>';
		$t->set_var("bars",$graph);
	
	$graph_values='<table cellpadding="0" cellspacing="0" align ="left" width="{size}"><tr>';
		foreach ($ids as $key => $id) {
			$i++;$k++;
			$query="SELECT * FROM cycle WHERE id='".$id."'";
			$q->query($query);
			$q->next_record();
			$text=$q->f("text");
			$campaign[$i]=htmlentities($text).'<br>';
			$graph_values.='<td align ="center" width="50"><a href="#" onmouseover="DivSetVisible(true,'.$k.');" onmouseout="DivSetVisible(false,'.$k.')"><font size=-5>value '.$i.'</font></a>';
			$graph_values.='</td>';
			$graph_values.='<div id="Div'.$k.'" style="position:absolute;  top:25px; left:50px; padding:4px; display:none; background-color:#FFFFFF; z-index:100; border:solid; border-width:thin; border-color:#CC3300"> 
			'.$campaign[$i].'</div>';
		}
		$graph_values.='</tr></table>';
		
		$t->set_var("values",$graph_values);
		$t->set_var("winner",$button);
	unset($ids);
	$t->set_var("cols",$count+2);
	$t->set_var("size",$size);
	$t->set_var("width",$size);
	$t->parse("rows","cyclelist",true);
	$camp='';
	$count=0;
	$size=0;
	}
else $t->set_var("rows","");
include("inc.bottom.php");
?>