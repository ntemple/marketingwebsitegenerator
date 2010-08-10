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
	$q2=new CDB;
	$t->set_file("content", "admin.members.html");
	$t->set_file("members_row", "admin.members.row.html");
	$t->set_file("members_item", "admin.members.item.html");
	
	$action="search";
	if (!isset($page)) $page=1;
	if (!isset($selectfield))
	{
		$selectfield[0]="id";
		$selectfield[1]="email";
		$selectfield[2]="first_name";
		$selectfield[3]="last_name";
		$selectfield[4]="paypal_email";
		$selectfield[6]="s_date";
		$selectfield[7]="aff";
		$selectfield[8]="jv";
		
	}
	
	$filter='';
	
	if (!isset($search)) $search="id";
	if (!isset($order)) $order="id";
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
						
						if ($i<count($selectfield)) $selecta.=$field.", ";
						else $selecta.=$field;
						$nextlink.="&selectfield[".($i-1)."]=".$field;
					}
					
			$selecta = str_replace(", affiliate_name",'',$selecta);
			$filter.="&search=".$search."&criteria=".$criteria;
			
			$query="select id,$selecta,password, membership_id from members  ";
			
			}
		$query.="where $search like '%$criteria%' AND ";
		
		if ($membership_search) {		
			foreach ($membership_search as $x => $value)
				{
					if (isset($membership_search_hide[$x])) {
						if ($k==0) {$query.="(membership_id='$x'";$k=1;}
						else $query.=" or membership_id='$x'";
					} else {
						if ($k==0) {$query.="(membership_id='$x'";$k=1;}
						else $query.=" or membership_id='$x'";
					}
				}
			$query.=")";
		} else {
			$query.="id!='1'";
		}
		
		if ($start && $start!="") {
			$query.=" and s_date >$start and s_date < $end";
		}
			
						
			
		$query_total="select count(*) as n from members";
		$q->query($query_total);
		$q->next_record();
		
		$query_count="select count(*) as n from members where $search like '%$criteria%'";
	
		$q->query($query_count);
		$q->next_record();
		$total=$q->f("n");
		$t->set_var("total_search", $total);
		$total_pages=(int)($total/100);
		if ($total%100!=0) $total_pages++;
		
		$inf=($page-1)*100;
		
		$t->set_var("showing_members", $inf."-".$sup);
		if ($order) $query.=" order by $order $sort";
		$q->query($query);
		
		
		
		$i=1;
		
		$export='';
		$j=0;
		while ($i<=count($selectfield))
		{	
			if ($type==1 && $selectfield[$i]!='affiliate_name')
			{
				if ($j==0) 
				{	
					$export.=$selectfield[$i]."\t";
					
				}
				else 
				{
					$export.=$selectfield[$i];
					$j=1;
				}
			 }
			if ($type==2 && $selectfield[$i]!='affiliate_name')
			{
				if ($j==0) 
				{	
					$export.="\"".$selectfield[$i]."\"";
					$j=1;
				}
				else $export.=",\"".$selectfield[$i]."\"";
			}
			$i++;
		}
		$export.="\n";
		$fields='';
		
		while ($q->next_record())
		{
		$j=0;
				$i=1;
				while ($i<=count($selectfield))
				{	
					$sel_field=$selectfield[$i];
					if ($sel_field=="s_date") $fields=$q->f($sel_field);
					else $fields=$q->f($sel_field);
					$fields=str_replace(",","#$%^&*", $fields);
					$fields=str_replace("\"","'", $fields);
					if ($sel_field=="jv") 
					{
						if ($q->f("jv")==1) $fields="1";
						if ($q->f("jv")==2) $fields="2";
						if ($q->f("jv")==0) $fields="0";
					}
				if ($sel_field=="affiliate_name") 
					{
						$eee1=1;
					}
					if ($type==1)
					{
						if ($j==0) 
						{	
							$export.=$fields."\t";
						}
						else 
						{
						$j=1;
						$export.=$fields;
						}
					}
					if ($type==2)
					{
						if ($j==0) 
						{	
							if (empty($fields)){
								$export.="\"".$fields."\"";
							}else{
								$export.="\"".$fields."\"";
							}
							$j=1;
						}
						else 
							if (empty($fields)){
								$export.=",\"".$fields."\"";
							}else{
								$export.=",\"".$fields."\"";
							}
					}
					
					$i++;
				}
			$export.="\n";
		}
	}
$filename_for_user = "members_".date("m-d-Y").".csv"; 
header ("Content-Type: application/octet-stream"); 
header ("Content-Length: " . strlen($export)); 
header ("Content-Disposition: attachment; filename=$filename_for_user"); 
echo $export; 
die();
include('inc.bottom.php');
?>
