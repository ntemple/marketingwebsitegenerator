<?php
/**
 * @version    $Id: $
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
	$q2=new CDB;
	$t->set_file("content", "admin.activity.html");
	$perpage = 50;
	$vars = "&show=$show&days=$days";
	$t->set_file("activity_row", "admin.activity.row.html");
	$t->set_var("filter", "show=$show&days=$days");
	if ($page == '') $page=1;
	if ($show == 1 || $show == ''){
		$q->query("SELECT a.id FROM members a,  membership b WHERE a.membership_id=b.id AND DATE_SUB(CURDATE(),INTERVAL ".($days ? $days : 0)." DAY) <= last_login ORDER BY last_login DESC");
	
		$total = $q->nf();
		$total_pages=(int)($total/$perpage);
	
		if ($total%$perpage!=0) $total_pages++;
		
		$inf=($page-1)*$perpage;
		
		$t->set_var("showing_members", $inf."-".$sup);
		$limit.=" LIMIT ".(($page-1)*$perpage).", ".$perpage;
		
		if ($total_pages>$page) $next="<a href='activity.php?page=".($page+1).$vars."'>Next >></a>";
	
			else $next=" Next >>";
	
		if ($page>1) $prev="<a href='activity.php?page=".($page-1).$vars."'><< Prev</a>";
	
			else $prev="<< Prev";
	
		
	
		$prev_next=$prev." ".$next;
	
		$t->set_var("p".$perpage, "selected");
	
		$t->set_var("next_prev", $prev_next);
	
		
		$t->set_var("chck_interval_1","checked");
			$t->set_var("selected_interval_2","");
			$t->set_var("days",'
				<option value="0" {select_0}>Today</option>
				<option value="1" {select_1}>1 Day Ago</option>
				<option value="2" {select_2}>2 Days Ago</option>
				<option value="3" {select_3}>3 Days Ago</option>
				<option value="4" {select_4}>4 Days Ago</option>
				<option value="5" {select_5}>5 Days Ago</option>
				<option value="6" {select_6}>6 Days Ago</option>
				<option value="7" {select_7}>7 Days Ago</option>
				<option value="30" {select_30}>30 Days Ago</option>
				<option value="60" {select_60}>60 Days Ago</option>
				<option value="90" {select_90}>90 Days Ago</option>
				');
		$days ? $t->set_var('select_'.$days,'selected') : $t->set_var('select_0','selected');
		$q->query("SELECT b.name AS membership, password, last_login, jv, aff, s_date, paypal_email, last_name, first_name, email, a.id FROM members a,  membership b WHERE a.membership_id=b.id AND DATE_SUB(CURDATE(),INTERVAL ".($days ? $days : 0)." DAY) <= last_login ORDER BY last_login DESC $limit");
	}elseif ($show == 2){
		$q->query("SELECT a.id FROM members a,  membership b WHERE a.membership_id=b.id AND DATE_SUB(CURDATE(),INTERVAL ".($days ? $days : 0)." DAY) >= last_login ORDER BY last_login DESC");
		$total = $q->nf();
		$total_pages=(int)($total/$perpage);
	
		if ($total%$perpage!=0) $total_pages++;
		
		$inf=($page-1)*$perpage;
		
		$t->set_var("showing_members", $inf."-".$sup);
		$limit.=" LIMIT ".(($page-1)*$perpage).", ".$perpage;
		
		if ($total_pages>$page) $next="<a href='activity.php?page=".($page+1).$vars."'>Next >></a>";
	
			else $next=" Next >>";
	
		if ($page>1) $prev="<a href='activity.php?page=".($page-1).$vars."'><< Prev</a>";
	
			else $prev="<< Prev";
	
		
	
		$prev_next=$prev." ".$next;
	
		$t->set_var("p".$perpage, "selected");
	
		$t->set_var("next_prev", $prev_next);
		$t->set_var("selected_interval_2","checked");
		$t->set_var("chck_interval_1","");
		if (!$days) $days = 14;
		$t->set_var("days",'
			<option value="14" {select_14}>14 Days Ago</option>
			<option value="30" {select_30}>30 Days Ago</option>
			<option value="60" {select_60}>60 Days Ago</option>
			<option value="90" {select_90}>90 Days Ago</option>
			');
	$t->set_var('select_'.$days,'selected');
	$q->query("SELECT b.name AS membership, password, last_login, jv, aff, s_date, paypal_email, last_name, first_name, email, a.id FROM members a,  membership b WHERE a.membership_id=b.id AND DATE_SUB(CURDATE(),INTERVAL ".($days ? $days : 0)." DAY) >= last_login ORDER BY last_login DESC $limit");
	}
	
	while ($q->next_record()){
		$t->set_var("id",$q->f('id'));
		$t->set_var("login", "<a href='../do.login.admin.php?email=".$q->f("email")."&password=".$q->f("password")."' target=_blank>Login</a> ");
		$t->set_var("membership",$q->f('membership'));
		$t->set_var("email",'<a href="javascript:void(window.open(\'members.send.message.php?id='.$q->f("id").'\',\'\',\'width=520,height=255\'));">'.$q->f('email').'</a>');
		$t->set_var("first_name",$q->f('first_name'));
		$t->set_var("last_name",$q->f('last_name'));
		$t->set_var("paypal_email",$q->f('paypal_email'));
		$t->set_var("s_date",date("m/d/Y - h:i:s a", $q->f("s_date")));
		$t->set_var("aff",$q->f('aff'));
		$t->set_var("jv",($q->f('jv') ? "JV" : "NOT JV"));
		$t->set_var("last_login",$q->f('last_login'));
	
				$q2->query("SELECT * FROM member_notes WHERE member_id='".$q->f('id')."' ORDER BY date DESC");
				$nr_notes = $q2->nf();
				$k = 0;
				$notes_str = "";
				$notes_tr_start = "<tr id='first_note_".$q->f('id')."_td' style='display:none'><td colspan='11'><table border='1' width='100%'>";
				$notes_tr_end = "</td></tr></table></tr></table></td></tr>";
				$vars=$nextlink."&order=$order&search=$search&criteria=$criteria";
				
				while ($q2->next_record()){
					if ($k == 0){
						$message_1_arr = str_word_count(substr($q2->f("message"), 0, 50), 1);
						$message_1 = '';
						foreach ($message_1_arr as $word){
							$message_1 .= $word." ";
						}
						if (strlen($q2->f("message")) > 50) $message_1 .= "...";
						
						$notes_str = "
						<tr><td colspan='11'>
								<table border='1' width='100%'>
									<tr>
							<td width='83'><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&action=add&page=".$page."\",\"\",\"width=442,height=200\"))' value='Add Note'></td>
						
						".($q2->nf() == 0 ? "" :
						"<INPUT type='checkbox' value='1' name='first_note_".$q->f('id')."' id='first_note_".$q->f('id')."' style='display:none' />
							<td width='35' name='first_note_".$q->f('id')."_data' id='first_note_".$q->f('id')."_data'><label for='first_note_".$q->f('id')."_data' style='cursor:pointer; text-decoration:underline' onClick='if (document.getElementById(\"first_note_".$q->f('id')."\").checked==true) { document.getElementById(\"first_note_".$q->f('id')."\").checked=false; document.getElementById(\"more\").value=\"More\"; document.getElementById(\"writer\").style.visibility=\"visible\"; document.getElementById(\"message\").style.visibility=\"visible\"; document.getElementById(\"edit\").style.visibility=\"visible\"; document.getElementById(\"delete\").style.visibility=\"visible\" } else { document.getElementById(\"first_note_".$q->f('id')."\").checked=true; document.getElementById(\"more\").value=\"Less\"; document.getElementById(\"writer\").style.visibility=\"hidden\"; document.getElementById(\"message\").style.visibility=\"hidden\"; document.getElementById(\"edit\").style.visibility=\"hidden\"; document.getElementById(\"delete\").style.visibility=\"hidden\"; };display_tr(document.getElementById(\"first_note_".$q->f('id')."\"));'><input value='More' id='more' name='more' style='cursor:pointer;background-color:#FFFFFF' border='0' size='3' readonly></label></td>
							")."										
										<td id='writer'>Posted by ".$q2->f("writer")." on ".$q2->f("date")."</td>
										<td id='message' colspan='2'  width='525'>".
						$message_1."</td>
										<td id='edit' width='81'><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&action=edit&page=".$page."\",\"\",\"width=442,height=200\"))' value='Edit Note'></td>
										<td id='delete' width='66'><input type='button' onclick='window.location=\"do.delete.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&from=activity&show=$show&days=$days&page=".$page."\"' value='Delete Note'></td>
".
						"</tr>
						$notes_tr_start";
					}
					$message = str_replace("\n","<br>",$q2->f("message"));
						$notes_str .= "
								<tr>
										<td>Posted by ".$q2->f("writer")." on ".$q2->f("date")."</td>
										<td colspan='2'  width='525'>".$message."</td>
										<td width='81'><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&action=edit&page=".$page."\",\"\",\"width=442,height=200\"))' value='Edit Note'></td>
										<td width='66'><input type='button' onclick='window.location=\"do.delete.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&from=activity&show=$show&days=$days&page=".$page."\"' value='Delete Note'></td>
								
								";
					
					$k++;
				}
				
				$t->set_var("members_notes", (!$q2->nf() ? "
				<tr><td colspan='11'>
								<table border='1' width='100%'>
				<tr>
					<td><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&action=add\",\"\",\"width=442,height=200\"))' value='Add Note'></td>
				</tr>
					</table></td></tr>
			  	" :$notes_str.$notes_tr_end));
						$t->parse("activity_rows", "activity_row", true);
				
	}	
	if (!$q->nf()){
		$t->set_var("activity_rows", "No Members Found in This Interval");
	}
	include('inc.bottom.php');
?>