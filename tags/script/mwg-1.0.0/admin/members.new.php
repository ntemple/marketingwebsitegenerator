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

 
	set_time_limit(0);
	include("inc.top.php");
	$q2=new CDB;
	$q3=new CDB;
	$q4=new CDB;
	$q5=new CDB;
	$t->set_file("content", "admin.members.html");
	$t->set_file("members_row", "admin.members.row.html");
	$t->set_file("members_item", "admin.members.item.html");
	
	//filters start
	if (!isset($membership_search)) $membership_search=array();
	$update_last_filter=0;
	if ($filtern && $filterv) {
		$query="INSERT INTO filters SET name='$filtern', filter='".urldecode($filterv)."'";
		$q2->query($query);
		$filter_save=mysql_insert_id($q2->link_id());
	}
	$filter_current=array();
	if ($search && ($criteria || $criteria==="0")) {
		$filter_current['search']=$search;
		$filter_current['criteria']=$criteria;
		mysql_query($query);
	}
	if (isset($selectfield)) {$filter_current['selectfield']=$selectfield; $update_last_filter=1;}
	if (isset($month_start)) {$filter_current['month_start']=$month_start; $update_last_filter=1;}
	if (isset($day_start)) {$filter_current['day_start']=$day_start; $update_last_filter=1;}
	if (isset($year_start)) {$filter_current['year_start']=$year_start; $update_last_filter=1;}
	if (isset($month_end)) {$filter_current['month_end']=$month_end; $update_last_filter=1;}
	if (isset($day_end)) {$filter_current['day_end']=$day_end; $update_last_filter=1;}
	if (isset($year_end)) {$filter_current['year_end']=$year_end; $update_last_filter=1;}
	if (isset($joined)) {$filter_current['joined']=$joined; $update_last_filter=1;}
	if (isset($msearch)) {$filter_current['msearch']=$msearch; $update_last_filter=1;}
	if (isset($membership_search) && count($membership_search)>0) {$filter_current['membership_search']=$membership_search; $update_last_filter=1;}
	if (isset($order)) {$filter_current['order']=$order; $update_last_filter=1;}
	if (isset($sort)) {$filter_current['sort']=$sort; $update_last_filter=1;}
	if (isset($filter_current) && count($filter_current)>0 && $update_last_filter==1) {
		$filter_current=serialize($filter_current);
		$query="UPDATE filters SET filter='$filter_current' WHERE id='0'";
		mysql_query($query);
		$new_filter=$filter_current;
	}
	if ($filter_save && $del!=1 && $ren!=1 && $rep!=1) {
		$query="SELECT * FROM filters WHERE id='$filter_save'";
		$q5->query($query);
		$q5->next_record();
		$query="UPDATE filters set filter='".$q5->f('filter')."' WHERE id='0'";
		$q5->query($query);
		$filter_load=unserialize($q5->f('filter'));
	} elseif ($filter_save && $del==1) {
		$query="DELETE FROM filters WHERE id='$filter_save'";
		$q5->query($query);
		$query="SELECT * FROM filters WHERE id='0'";
		$q5->query($query);
		$q5->next_record();
		$filter_load=unserialize($q5->f('filter'));
	} elseif ($filter_save && $ren==1 && $filternn) {
		$query="UPDATE filters set name='$filternn' WHERE id='$filter_save'";
		$q5->query($query);
		$query="SELECT * FROM filters WHERE id='$filter_save'";
		$q5->query($query);
		$q5->next_record();
		$filter_load=unserialize($q5->f('filter'));
	} elseif ($filter_save && $rep==1 && $filterrv) {
		$query="UPDATE filters set filter='".urldecode($filterrv)."' WHERE id='$filter_save'";
		$q5->query($query);
		$query="SELECT * FROM filters WHERE id='$filter_save'";
		$q5->query($query);
		$q5->next_record();
		$filter_load=unserialize($q5->f('filter'));
	} elseif (!$godefault) {
		$query="SELECT * FROM filters WHERE id='0'";
		$q5->query($query);
		$q5->next_record();
		$filter_load=unserialize($q5->f('filter'));
	} elseif ($godefault) {
		$query="UPDATE filters set filter='' WHERE id='0'";
		$q5->query($query);
	}
	if ($filter_load['search'] && $filter_load['criteria']) {$search=$filter_load['search']; $criteria=$filter_load['criteria'];}
	if ($filter_load['selectfield']) {$selectfield=$filter_load['selectfield'];}
	if ($filter_load['month_start']) {$month_start=$filter_load['month_start'];}
	if ($filter_load['day_start']) {$day_start=$filter_load['day_start'];}
	if ($filter_load['year_start']) {$year_start=$filter_load['year_start'];}
	if ($filter_load['month_end']) {$month_end=$filter_load['month_end'];}
	if ($filter_load['day_end']) {$day_end=$filter_load['day_end'];}
	if ($filter_load['year_end']) {$year_end=$filter_load['year_end'];}
	if ($filter_load['joined']) {$joined=$filter_load['joined'];}
	if ($filter_load['msearch']) {$msearch=$filter_load['msearch'];}
	if ($filter_load['membership_search']) {$membership_search=$filter_load['membership_search'];}
	if ($filter_load['order']) {$order=$filter_load['order'];}
	if ($filter_load['sort']) {$sort=$filter_load['sort'];}
	if ($joined==1) {
		$t->set_var("joined", 'checked');
	}
	if ($sort=='desc') {
		$t->set_var("sortdesc", 'checked');
		$t->set_var("sortasc", '');
	} else {
		$t->set_var("sortdesc", '');
		$t->set_var("sortasc", 'checked');
	}
	$query="SELECT * FROM filters WHERE id!=0";
	$q5->query($query);
	if ($q5->nf()>0) {
		$filters='Load a saved filter to use :';
		$filters.='<form id="loadf" name="loadf" action="members.new.php" method="POST" target="iframe">';
		$filters.='<select id="filter_save" name="filter_save">';
		$filters.='<option value="0">Choose a filter</option>';
		while ($q5->next_record()) {
			if ($filter_save==$q5->f('id')) {
				$filters.='<option selected value="'.$q5->f('id').'">'.$q5->f('name').'</option>';
			} else {
				$filters.='<option value="'.$q5->f('id').'">'.$q5->f('name').'</option>';
			}
		}
		$filters.='</select>';
		$filters.='<input type="hidden" id="del" name="del" value="0">';
		$filters.='<input type="hidden" id="ren" name="ren" value="0">';
		$filters.='<input type="hidden" id="rep" name="rep" value="0">';
		$filters.='<label for="filternn" id="nnlabel" name="nnlabel" style="display:none">&nbsp;&nbsp;Filter new name: </label>';
		$filters.='<input type="hidden" name="filterrv" id="filterrv" value="'.urlencode($new_filter).'">';
		$filters.='<input type="text" id="filternn" name="filternn" value="" style="display:none" size="35">';
		$filters.='<input id="buttonload" name="buttonload" type="button" value="Load filter." onclick="
		if (document.loadf.filter_save.value==0) {
		alert(\'Please choose a filter first.\');
		exit;
		} else {
		document.loadf.submit();
		}
		">';
		$filters.='<input id="buttondel" name="buttondel" type="button" value="Delete filter." onclick="
		if (document.loadf.filter_save.value==0) {
		alert(\'Please choose a filter first.\');
		exit;
		}
		document.loadf.ren.value=0;
		document.loadf.rep.value=0;
		document.loadf.del.value=1;
		askdel(\'Are you sure you want to delete this filter?\');
		">';
		$filters.='<input id="buttonren" name="buttonren" type="button" value="Rename filter (step 1/2)." onclick="
		if (document.loadf.filter_save.value==0) {
		alert(\'Please choose a filter first.\');
		exit;
		}
		if (document.loadf.ren.value==0) {
		document.getElementById(\'nnlabel\').style.display=\'\';
		document.loadf.buttonload.style.display=\'none\';
		document.loadf.buttondel.style.display=\'none\';
		document.loadf.buttoncancel.style.display=\'\';
		document.loadf.filternn.style.display=\'\';
		document.loadf.ren.value=1;
		document.loadf.rep.value=0;
		document.loadf.del.value=0;
		document.loadf.buttonren.value=\'Rename filter (step 2/2).\';
		} else {
		if (document.loadf.filternn.value!=\'\') {
		document.loadf.submit();
		} else {
		alert (\'Please enter the new name for filter!\');
		}
		}
		">';
		$filters.='<input id="buttoncancel" name="buttoncancel" type="button" style="display:none" value="Cancel." onclick="
		document.getElementById(\'nnlabel\').style.display=\'none\';
		document.loadf.buttonload.style.display=\'\';
		document.loadf.buttondel.style.display=\'\';
		document.loadf.buttoncancel.style.display=\'none\';
		document.loadf.filternn.style.display=\'none\';
		document.loadf.ren.value=0;
		document.loadf.rep.value=0;
		document.loadf.del.value=0;
		document.loadf.buttonren.value=\'Rename filter (step 1/2).\';
		">';
		if ($new_filter!='') {
			$filters.='<br><input type="button" value="Replace selected filter with current search." onclick="
			document.loadf.ren.value=0;
			document.loadf.rep.value=1;
			document.loadf.del.value=0;
			askdel(\'Are you sure you want to replace this filter with current search?\');
			">';
		}
		$filters.='</form>';
	} else {
		$filters='No saved filters to load.';
	}
	if ($new_filter!='') {
		$filters.='<hr>';
		$filters.='<form id="savef" name="savef" action="" method="POST">';
		$filters.='<input type="hidden" name="filterv" id="filterv" value="'.urlencode($new_filter).'">';
		$filters.='New filter name: <input type="text" name="filtern" id="filtern" value="" size="35">';
		$filters.='<input type="button" value="Save this search as filter." onclick="if(document.savef.filtern.value==\'\') {alert(\'Please choose a name fo filter!\')} else {document.savef.submit();}">';
		$filters.='</form>';
	}
	$t->set_var("filters", $filters);
	//filters end
	
$action="search";
if ($search) { $t->set_var("search", $search); } else { $t->set_var("search", "id"); }
$overwrite_search=0;
if ($search=='affiliate_name' && ($criteria || $criteria==="0")) {
	$overwrite_search=1;
	$query="SELECT id FROM members WHERE first_name LIKE '$criteria' OR last_name LIKE '$criteria'";
	$q5->query($query);
	if ($q5->nf()>0) {
		$new_search.=' (';
		while ($q5->next_record()) {
			$new_search.="aff='".$q5->f('id')."' OR ";
		}
		$new_search.=" aff='-1')";
	} else {
		$new_search=" aff='-1'";
	}
}
if ($criteria || $criteria==="0") { $t->set_var("criteria", $criteria); } else { $t->set_var("criteria", "");}
if ($page) { $t->set_var("page", $page); } else { $t->set_var("page", "1"); }
		$query="select * from membership where active=1";
		$q->query($query);
		while ($q->next_record())
		{
			if (isset($membership_search_hide[$q->f("id")])) {
				$membership_search[$q->f("id")]=$q->f("id");
			}
		}
		
	if (count($membership_search)>0) {$from_change_membership=1;}
	if (!isset($page)) $page=1;
	$t->set_var("page_hide", '<input type="hidden" name="page" value="'.$page.'">');
	if (!isset($selectfield))
	{
		$selectfield=array();
		$selectfield[0]="id";
		$selectfield[1]="email";
		$selectfield[2]="first_name";
		$selectfield[3]="last_name";
		$selectfield[4]="paypal_email";
		$selectfield[5]="s_date";
		$selectfield[6]="aff";
		$selectfield[7]="jv";
		$selectfield[8]="active";
	}
	if (!isset($search)) $search="id";
	if (!isset($order) || $order=='affiliate_name') $order="id";
	if (!isset($perpage)) 
	{
		if (get_setting("searchperpage")!='')
		$perpage=get_setting("searchperpage");
		else
		$perpage=10;
		
	}
	if (!isset($msearch))
	{
		$msearch=1;
		$t->set_var('msearchany', 'checked');
		$t->set_var('msearchjust', '');
	} elseif ($msearch==1) {
		$t->set_var('msearchany', 'checked');
		$t->set_var('msearchjust', '');
	} else {
		$t->set_var('msearchany', '');
		$t->set_var('msearchjust', 'checked');
	}
	
	if ($action=="search")
	{
		if ($all) $query="select * from members ";
		else 
			{
				$i=0;
				$j=0;
				foreach ($selectfield as $field)
					{
						
						$i++;
						if ($field!='affiliate_name') {
							if ($i<count($selectfield)) $selecta.=$field.", ";
							else $selecta.=$field;
						} else {
							if ($i<count($selectfield)) $selecta.="aff, ";
							else $selecta.='aff';
						}
						
						
						$nextlink.="&selectfield[".($i-1)."]=".$field;
						if ($j==0)
						{	
							$filter.="selectfield[".$i."]=".$field;
							$j=1;
						}
						else $filter.="&selectfield[".$i."]=".$field;
					}
			$filter.="&search=".$search."&criteria="."$criteria";
			$query="select id,$selecta,password, membership_id from members  ";
			}
		
		if ($joined || $from_change_joined==1)
		{
			$nextlink.="&month_start=".$month_start;
			$nextlink.="&day_start=".$day_start;
			$nextlink.="&year_start=".$year_start;
			$nextlink.="&month_end=".$month_end;
			$nextlink.="&day_end=".$day_end;
			$nextlink.="&year_end=".$year_end;
			$nextlink.="&joined=1";
						
			if (isset($start) && $start!="") {
				$start=$start;
				$end=$end;
			} else {
				$start=mktime(0,0,0,$month_start, $day_start, $year_start);
				$end=mktime(24,0,0,$month_end, $day_end, $year_end);
			}
			
			if (($msearch==2 && count($membership_search)>0) || $from_change_membership==1) 
			{
				$k=0;
				$msearch_hide='';
				foreach ($membership_search as $x => $value)
				{
					if (isset($membership_search_hide[$x])) {
						if ($k==0) {$for_query.="(membership_id='$x'";$k=1;}
						else $for_query.=" or membership_id='$x'";
						$msearch_hide.='<input type="hidden" name="membership_search_hide['.$x.']" value="'.$x.'">';
						$new_membership.="&membership_search[".$x."]=$x";
					} else {
						if ($k==0) {$for_query.="(membership_id='$x'";$k=1;}
						else $for_query.=" or membership_id='$x'";
						$msearch_hide.='<input type="hidden" name="membership_search_hide['.$x.']" value="'.$x.'">';
						$new_membership.="&membership_search[".$x."]=$x";
					}
				}
				$for_query.=")";
				$count_query.="and ".$for_query;
				if ($overwrite_search==1) {
					$query.="where $new_search and s_date >$start and s_date < $end and id<>1 and ".$for_query;
					$search_query.="$search like '%$criteria%' and s_date >$start and s_date < $end and id<>1 and ".$for_query;
				} else {
					$query.="where $search like '%$criteria%' and s_date >$start and s_date < $end and id<>1 and ".$for_query;
					$search_query.="$search like '%$criteria%' and s_date >$start and s_date < $end and id<>1 and ".$for_query;
				}				
				$new_date="&start=$start&end=$end";
			}
			else
			{
				if ($overwrite_search==1) {
					$query.="where $new_search and s_date >$start and s_date < $end and id<>1";
					$search_query.=" $new_search and s_date >$start and s_date < $end and id<>1";
				} else {
					$query.="where $search like '%$criteria%' and s_date >$start and s_date < $end and id<>1";
					$search_query.=" $search like '%$criteria%' and s_date >$start and s_date < $end and id<>1";
				}
				$new_date="&start=$start&end=$end";
			}
		}
		else 
		{
			if (($msearch==2 && count($membership_search)>0) || $from_change_membership==1) 
			{
				$k=0;
				$msearch_hide='';
				foreach ($membership_search as $x => $value)
				{
					if (isset($membership_search_hide[$x])) {
						if ($k==0) {$for_query.="(membership_id='$x'";$k=1;}
						else $for_query.=" or membership_id='$x'";
						$msearch_hide.='<input type="hidden" name="membership_search_hide['.$x.']" value="'.$x.'">';
						$new_membership.="&membership_search[".$x."]=$x";
					} else {
						if ($k==0) {$for_query.="(membership_id='$x'";$k=1;}
						else $for_query.=" or membership_id='$x'";
						$msearch_hide.='<input type="hidden" name="membership_search_hide['.$x.']" value="'.$x.'">';
						$new_membership.="&membership_search[".$x."]=$x";
					}
				}
				$for_query.=")";
				$count_query.="and ".$for_query;
				if ($overwrite_search==1) {
					$query.="where $new_search and id<>1 and ".$for_query;
					$search_query.="$new_search and id<>1 and ".$for_query;
				} else {
					$query.="where $search like '%$criteria%' and id<>1 and ".$for_query;
					$search_query.="$search like '%$criteria%' and id<>1 and ".$for_query;
				}
			}
			else
			{
				if ($overwrite_search==1) {
					$query.="where $new_search and id<>1";
					$search_query.=" $new_search and id<>1";
				} else {
					$query.="where $search like '%$criteria%' and id<>1";
					$search_query.=" $search like '%$criteria%' and id<>1";
				}
			}
		}
		set_setting("searchperpage", $perpage);
		$t->set_var("search_query", "$search_query");
		$query_total="select count(*) as n from members where id<>1 ";
		$q->query($query_total);
		$q->next_record();
		$total=$q->f("n");
		$t->set_var("total_members", $total);
		
		
		$query_count="select count(*) as n from members where ";
		if (($criteria || $criteria==="0") && (!$start || $start=="")) {
		 	if ($overwrite_search==1) {
		 		$query_count.="$new_search and id<>1 ".$count_query;
		 	} else {
		 		$query_count.="$search like '%$criteria%' and id<>1 ".$count_query;
		 	}
		 } elseif (isset($start) && $start!="") {
		 	if ($overwrite_search==1) {
		 		$query_count.="$new_search and id<>1 and s_date >$start and s_date < $end ".$count_query;
		 	} else {
		 		$query_count.="id<>1 and id<>1 and s_date >$start and s_date < $end ".$count_query;
		 	}		
		 } else {
		 	if ($overwrite_search==1) {
		 		$query_count.=" $new_search and id<>1 ".$count_query;
		 	} else {
		 		$query_count.=" id<>1 ".$count_query;
		 	}
		 }
		
		$q->query($query_count);
		$q->next_record();
		$total=$q->f("n");
		$t->set_var("total_search", $total);
		$total_pages=(int)($total/$perpage);
		if ($total%$perpage!=0) $total_pages++;
		
		$inf=($page-1)*$perpage;
		
		$t->set_var("showing_members", $inf."-".$sup);
		if ($order) $query.=" order by $order $sort limit ".(($page-1)*$perpage).", ".$perpage;
		$q->query($query);
		
		
		
		$i=0;
		$t->set_var("field_name", "<b>Membership status:</b> ");
		$t->parse("members_items", "members_item", true);
		$t->set_var("field_name", "<b>Action</b>");
		$t->parse("members_items", "members_item", true);
		while ($i<count($selectfield))
		{	
			$fields='<b>'.$selectfield[$i].'</b>';
			$t->set_var("cancels", '');
			$t->set_var("field_name", $fields);
			
			$t->parse("members_items", "members_item", true);
			
			$i++;
		}
		$t->set_var("field_name", "<b>Select</b>");
		$t->set_var("members_notes", "");
			
		$t->parse("members_items", "members_item", true);
		$t->parse("members_rows", "members_row", true);
		$fields='';
		$t->clear_var("members_items");
		$j = 0;
		while ($q->next_record())
		{
				$i=0;
				
				$members_select = "Current membership:";
				$query="select * from membership where active=1 OR id='".$q->f("membership_id")."'";
				$q2->query($query);
				$members_select .= "<select name='member_".$q->f("id")."' id='member_".$q->f("id")."' style='width:170px'>									
									";
				while ($q2->next_record())
				{
					if ($q2->f("id") != $q->f("membership_id"))
						$members_select .= "<option value='".$q2->f("id")."'>".$q2->f("name")."</option>";
					else $members_select .= "<option value='".$q2->f("id")."' selected>".$q2->f("name")."</option>";
				}
				$members_select .= "</select>";
				
				
				$members_select .= "<img name='submit_membership'  style='cursor:pointer' src=\"../images/up_down.jpg\" width='20' height='20' alt='Upgrade/Downgrade' title='Upgrade/Downgrade' onclick=\"javascript:document.members.getAttributeNode('action').value='do.upgrade.php?mid=".$q->f("id")."&uid='+document.members.member_".$q->f("id").".options[document.members.member_".$q->f("id").".selectedIndex].value;document.members.submit()\">";
				
				$t->set_var("field_name", $members_select);
				$t->parse("members_items", "members_item", true);
				
				$t->set_var("field_name", "<a href='../do.login.admin.php?email=".$q->f("email")."&password=".$q->f("password")."' target=_blank>Login</a> ");
				$t->parse("members_items", "members_item", true);
				while ($i<count($selectfield))
				{	
					$sel_field=$selectfield[$i];
					if ($sel_field=="s_date") $fields=date("m/d/Y - h:i:s a", $q->f($sel_field));
					else $fields=$q->f($sel_field);
					if ($sel_field=="aff") 
					{
						if ($q->f($sel_field)!=0)
						{
							$fields='<span onmouseover="DivSetVisible(true,\'ref_'.$q->f("id").'\', 500);" onmouseout="DivSetVisible(false, \'ref_'.$q->f("id").'\', 500);">'.$q->f($sel_field).'</span>';
							$query="select id, s_date as signup_date,email,  membership_id, concat(first_name,' ',last_name) as name from members where id='".$q->f($sel_field)."'";
							
							$q3->query($query);
							$q3->next_record();
							$affiliate_name=$q3->f("name");
							$affiliate_email=$q3->f("email");
							$affiliate_signup_date=date("m/d/Y", $q3->f("signup_date"));
							$affiliate_membership_id=$q3->f("membership_id");
							$query="select name from membership where id='$affiliate_membership_id'";
							$q3->query($query);
							$q3->next_record();
							$affiliate_membership=$q3->f("name");
							$fields.='<div id="ref_'.$q->f("id").'" style="padding: 4px; position: absolute; display: none; z-index: 100; font-family: Verdana,Arial,Helvetica,sans-serif; font-size: 13px; font-weight: normal; left: 622px; border: solid 1px #000000; background-color: #FFFFFF;">'.$affiliate_name.'<br>'.$affiliate_email.'<br> - '.$affiliate_membership.'<br> since '.$affiliate_signup_date.'</div>';
						}
						else $fields=0;
					}
					if ($sel_field=="email") $fields='<a href="javascript:void(window.open(\'members.send.message.php?id='.$q->f("id").'\',\'\',\'width=520,height=255\'));">'.$q->f($sel_field).'</a>';
					if ($sel_field=="jv") 
					{
						if ($q->f("jv")==1) $fields="JV 1";
						if ($q->f("jv")==2) $fields="JV 2";
						if ($q->f("jv")==0) $fields="Not JV";
					}
					if ($sel_field=="active") 
					{
						if ($q->f("active")==0) $fields="<center>NO</center>";
						if ($q->f("active")==1) $fields="<center>YES</center>";
					}
					if ($sel_field=="affiliate_name") 
					{
						if ($q->f("aff")!=0) {
							$query="SELECT first_name, last_name FROM members WHERE id='".$q->f("aff")."'";
							$q5->query($query);
							$q5->next_record();
							$fields=$q5->f('first_name')." ".$q5->f('last_name');
						} else {
							$fields='none';
						}
						
					}					
					$t->set_var("field_name", $fields."&nbsp;");
					$t->parse("members_items", "members_item", true);
					$i++;
				}
			$t->set_var("field_name", "<input name='check[".$q->f("id")."]' type=checkbox>");
			$t->parse("members_items", "members_item", true);
			
				$q2->query("SELECT * FROM member_notes WHERE member_id='".$q->f('id')."' ORDER BY date DESC");
				$nr_notes = $q2->nf();
				$j = 0;
				$notes_str = "";
				$notes_tr_start = "<tr id='first_note_".$q->f('id')."_td' style='display:none'><td colspan='".(count($selectfield)+3 < 6 ? 7 : count($selectfield)+3)."'><table border='1' width='100%'>";
				$notes_tr_end = "</td></tr></table></tr></table></td></tr>";
				$vars=$nextlink."&order=$order&search=$search&criteria=$criteria";
				
				while ($q2->next_record()){
					if ($j == 0){
						$message_1_arr = str_word_count(substr($q2->f("message"), 0, 50), 1);
						$message_1 = '';
						foreach ($message_1_arr as $word){
							$message_1 .= $word." ";
						}
						if (strlen($q2->f("message")) > 50) $message_1 .= "...";
						
						$notes_str = "
						<tr><td colspan='".(count($selectfield)+3)."'>
								<table border='1' width='100%'>
									<tr>
							<td width='83'><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&action=add&page=".$page.$vars."\",\"\",\"width=442,height=200\"))' value='Add Note'></td>
						
						".($q2->nf() == 0 ? "" :
						"<INPUT type='checkbox' value='1' name='first_note_".$q->f('id')."' id='first_note_".$q->f('id')."' style='display:none' />
							<td width='35' name='first_note_".$q->f('id')."_data' id='first_note_".$q->f('id')."_data'><label for='first_note_".$q->f('id')."_data' style='cursor:pointer; text-decoration:underline' onClick='if (document.getElementById(\"first_note_".$q->f('id')."\").checked==true) { document.getElementById(\"first_note_".$q->f('id')."\").checked=false; document.getElementById(\"more\").value=\"More\"; document.getElementById(\"writer\").style.visibility=\"visible\"; document.getElementById(\"message\").style.visibility=\"visible\"; document.getElementById(\"edit\").style.visibility=\"visible\"; document.getElementById(\"delete\").style.visibility=\"visible\" } else { document.getElementById(\"first_note_".$q->f('id')."\").checked=true; document.getElementById(\"more\").value=\"Less\"; document.getElementById(\"writer\").style.visibility=\"hidden\"; document.getElementById(\"message\").style.visibility=\"hidden\"; document.getElementById(\"edit\").style.visibility=\"hidden\"; document.getElementById(\"delete\").style.visibility=\"hidden\"; };display_tr(document.getElementById(\"first_note_".$q->f('id')."\"));'><input value='More' id='more' name='more' style='cursor:pointer;background-color:#FFFFFF' border='0' size='3' readonly></label></td>
							")."										
										<td id='writer'>Posted by ".$q2->f("writer")." on ".$q2->f("date")."</td>
										<td id='message' colspan='2'  width='525'>".
						$message_1."</td>
										<td id='edit' width='81'><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&action=edit&page=".$page.$vars."\",\"\",\"width=442,height=200\"))' value='Edit Note'></td>
										<td id='delete' width='66'><input type='button' onclick='window.location=\"do.delete.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&page=".$page.$vars."\"' value='Delete Note'></td>
".
						"</tr>
						$notes_tr_start";
					}
					$message = str_replace("\n","<br>",$q2->f("message"));
						$notes_str .= "
								<tr>
										<td>Posted by ".$q2->f("writer")." on ".$q2->f("date")."</td>
										<td colspan='2'  width='525'>".$message."</td>
										<td width='81'><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&action=edit&page=".$page.$vars."\",\"\",\"width=442,height=200\"))' value='Edit Note'></td>
										<td width='66'><input type='button' onclick='window.location=\"do.delete.member.note.php?member_id=".$q->f('id')."&note_id=".$q2->f('id')."&page=".$page.$vars."\"' value='Delete Note'></td>
								
								";
					
					$j++;
				}
				
				$t->set_var("members_notes", (!$q2->nf() ? "
				<tr><td colspan='".(count($selectfield)+3)."'>
								<table border='1' width='100%'>
				<tr>
					<td><input type='button' onclick='javascript:void(window.open(\"admin.member.note.php?member_id=".$q->f('id')."&action=add\",\"\",\"width=442,height=200\"))' value='Add Note'></td>
				</tr>
					</table></td></tr>
			  	" :$notes_str.$notes_tr_end));
			$j++;
			$t->parse("members_rows", "members_row", true);
			$t->clear_var("members_items");
		}
		$t->set_var("showing_members", $inf."-".(($page-1)*$perpage+$q->nf()) );
	}
		
		
	
	if ($q->nf()==0) $t->set_var("members_rows","");
	$vars_new=$nextlink."&order=$order&search=$search&criteria=$criteria$new_membership$new_date";
	if ($total_pages>$page) $next="<a href='members.php?page=".($page+1).$vars_new."'>Next >></a>";
		else $next=" Next >>";
	if ($page>1) $prev="<a href='members.php?page=".($page-1).$vars_new."'><< Prev</a>";
		else $prev="<< Prev";
	$filter.="$new_membership$new_date";
	$t->set_var("filter", $filter);
	$prev_next=$prev." ".$next;
	$t->set_var("p".$perpage, "selected");
	$t->set_var("next_prev", $prev_next);
	$b=getdbfields2("check", 5);
	$t->set_var("fields_list", $b);
	$c=getdbfields("select", 0);
	$t->set_var("criteria_fields", $c);
	$c=getdbfields("select_s", 0);
	$t->set_var("search_fields", $c);
		for ($i=1;$i<=31;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			if (!$day_start) $day_start_sel .= "<option value='$i' name='".$k."' ".($i == date("j")-1 ? "selected" : "").">$i</option>";
			else $day_start_sel .= "<option value='$i' name='".$k."' ".($i == $day_start ? "selected" : "").">$i</option>";
		}
		
		for ($i=1;$i<=12;$i++){
			$k = $i-1;
			if ($i<10) $i="0".$i;
			if (!$month_start) $month_start_sel .= "<option value='$i' name='".$k."' ".($i == date("n") ? "selected" : "").">$i</option>";
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
	$t->set_var("day_start",$day_start_sel);
	$t->set_var("month_start",$month_start_sel);
	$t->set_var("year_start",$year_start_sel);
	$query="select * from membership where active=1";
	$q->query($query);$msearch='';
	while ($q->next_record())
	{
		$msearch_t.='    <input type="checkbox" name="membership_search['.$q->f("id").']" id="membership_search['.$q->f("id").']" value="'.$q->f("id").'"  onClick="checkit(\'msearch\');" '.(in_array($q->f("id"), $membership_search)? "checked" : (count($membership_search)<1 ? "checked" : "")).'>'.$q->f("name");
		$checkitall.="document.getElementById('membership_search[".$q->f("id")."]').checked=true;";
		$membership_select.='<option value="'.$q->f("id").'">'.$q->f("name").'</option>';
		$membership_select_item.='<option value="'.$q->f("id").'">'.$q->f("name").' ITEMS</option>';
		
	}
	$t->set_var("checkitall", $checkitall);
	$t->set_var("start", $start);
	$t->set_var("end", $end);
	$t->set_var("msearch_hide", $msearch_hide);
	$t->set_var("membership_search_list", $msearch_t);
	$t->set_var("membership_select", $membership_select);
	$t->set_var("membership_select_item", $membership_select_item);
	$t->set_var("day_end",$day_end_sel);
	$t->set_var("month_end",$month_end_sel);
	$t->set_var("year_end",$year_end_sel);
	
	if ($_GET['menu'] == "settings"){
		$_SESSION['menu'] = "settings";
	}elseif ($_GET['menu'] == "members"){
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
	$t->set_file("main", "admin.main.".$_SESSION['menu'].".html");
	
	$query="select id from messages where member_id=1 and read_flag=0";
	$q->query($query);
	$q->next_record();
	FFileRead("../config/version", $version);
	$t->set_var("version", $version);
	$t->set_var("newmessages", $q->nf());
	$t->set_var("sitename", SITENAME);
	
	$ocontent=$t->parse("page", "content");
	echo '<div id="members_content_hide" name="members_content_hide">'.$ocontent.'</div>';
	
	die("<script> parent.document.getElementById('members_content').innerHTML=document.getElementById('members_content_hide').innerHTML;document.getElementById('members_content_hide').innerHTML=''; </script>");
?>