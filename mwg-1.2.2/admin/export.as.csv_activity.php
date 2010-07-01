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
	
	if (!isset($selectfield))
	{
		$selectfield[0]="a.id";
		$selectfield[1]="email";
		$selectfield[2]="first_name";
		$selectfield[3]="last_name";
		
		$selectfield[4]="membership";
		$selectfield[5]="paypal_email";
		$selectfield[6]="s_date";
		$selectfield[7]="aff";
		$selectfield[8]="jv";
		
		$selectfield[9]="last_login";
	}
	
				$i=0;
				$j=0;
				foreach ($selectfield as $field)
					{
						if ($field == "membership"){
							;
						}else{
						
						$i++;
						
						if ($i<count($selectfield)) $selecta.=$field.", ";
						else $selecta.=$field;
						$nextlink.="&selectfield[".($i-1)."]=".$field;
						}
					}
			$selecta = substr($selecta,0,-2);
		if ($show == 1 || $show == ''){
			$where = "WHERE a.membership_id=b.id AND  DATE_SUB(CURDATE(),INTERVAL ".($days ? $days : 0)." DAY) <= last_login ORDER BY last_login DESC";
		}else{
			$where = "WHERE a.membership_id=b.id AND  DATE_SUB(CURDATE(),INTERVAL ".($days ? $days : 0)." DAY) >= last_login ORDER BY last_login DESC";
		}
					
		$query="select $selecta,password, b.name AS membership from members a,  membership b  $where";
		
		$q->query($query);
		$i=1;
		
		$export='';
		$j=0;
		while ($i<=count($selectfield))
		{	
			if ($type==1)
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
			if ($type==2)
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
					if ($sel_field=="s_date") $fields=date("m/d/Y - h:i:s a", $q->f($sel_field));
					else $fields=$q->f($sel_field);
					if ($sel_field=="jv") 
					{
						if ($q->f("jv")==1) $fields="JV 1";
						if ($q->f("jv")==2) $fields="JV 2";
						if ($q->f("jv")==0) $fields="Not JV";
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
								$export.="";
							}else{
								$export.="\"".$fields."\"";
							}
							$j=1;
						}
						else 
							if (empty($fields)){
								$export.=",".$fields."";
							}else{
								$export.=",\"".$fields."\"";
							}
					}
					
					$i++;
				}
			$export.="\n";
		}
if ($show == 1 || $show == ''){
	$name = 'active_members_';
}else {
	$name = 'inactive_members_';
}
$name .= $days."_days_";
$filename_for_user = $name.date("m-d-Y").".csv"; 
header ("Content-Type: application/octet-stream"); 
header ("Content-Length: " . strlen($export)); 
header ("Content-Disposition: attachment; filename=$filename_for_user"); 
echo $export; 
	include('inc.bottom.php');
?>