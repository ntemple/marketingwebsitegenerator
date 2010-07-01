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
  MWG::getInstance()->response->initEditor();
	$q2 = new CDb();
	$t->set_file("content", "admin.login_msg.html");
	$t->set_file("messagelist", "admin.login_msg.item.html");
	$query="select * from after_login";
	$q->query($query);
	$chck_funtions = '';
	while ($q->next_record())
	{
		$membership_select = '';
		$t->set_var("msg",$q->f("id"));
		$t->set_var("nr_days",$q->f("nr_days"));
		$t->set_var("count",$q->f("count"));
		$t->set_var("active_chck",$q->f("active") ? "checked" : "");
		if ($q->f("membership") != 'all'){
			$chck_funtions .= "document.getElementById('membership_td_".$q->f("id")."').style.display='';";
		}
		$t->set_var("checked_all",$q->f("membership") == 'all' ? "checked" : "");
		$t->set_var("checked_just",$q->f("membership") != "all" ? "checked" : "");
		$membership_arr = explode(",",$q->f('membership'));
		$query="select id, name from membership where active=1";
		$q2->query($query);
		while($q2->next_record()){
			$chck = "";
			if (in_array($q2->f('id'),$membership_arr)){
				$chck = "checked";
			}
			$membership_select .= "
			<tr>
				<td><input value='".$q2->f('id')."' $chck name='membership_".$q->f("id")."[".$q2->f('id')."]' type='checkbox'>".$q2->f('name')."</td>
			</tr>";
		}	
		$t->set_var("membership_list",$membership_select);
		$t->parse("message_list", "messagelist", true);
	}
	if ($q->nf()==0) $t->set_var("message_list", "");
	
	$query="select id, name from membership where active=1";
	$q2->query($query);
	$membership_select = '';
	while($q2->next_record()){
		$membership_select .= "
		<tr>
			<td><input value='".$q2->f('id')."' name='membership[".$q2->f('id')."]' type='checkbox'>".$q2->f('name')."</td>
		</tr>";
	}
		
	$t->set_var("membership_list",$membership_select);
	$t->set_var("chck_funtions",$chck_funtions);
	include('inc.bottom.php');
?>