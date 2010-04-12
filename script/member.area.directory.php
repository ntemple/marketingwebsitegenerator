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
		$q2 = new Cdb;
	if (get_setting("enable_profile_directory")==1){
	 get_logged_info();
	 $q2=new CDB;
	 $query="SELECT id FROM menus WHERE link='member.area.directory.php'";
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
		$t->set_file("content", "member.area.directory.html");
		$t->set_var("search", $search);
		if (!isset($search)) $sea=" public_profile=1 ";
		else
		{
			$sea=" (public_profile=1) and (last_name like '%$search%' or first_name like '%$search%' or country like '%$search%' or city like '%$search%' or state like '%$search%'  or email like '%$search%'  or email like '%$search%'  or state like '%$search%'  or zip like '%$search%') ";
		}
		
		if (!isset($page)) $page=1;
		if (!isset($orx)) $orx=" asc ";
		
		if (!isset($order)) $order="id";
		
		
		$query="select count(*) as n from members where $sea  order by $order ";
		$q->query($query);
		$q->next_record();
		
		$total=$q->f("n");  
		
		
		
				$total_p=(int) ($total/100);
			if ($total%100>0) $total_p++;
			if ($page>1) $prev="<a href='member.area.directory.php?order=$order&page=".($page-1)."&search=$search&photo_only=$photo_only&orx=$orx'>&lt; Previous</a>";
			else $prev="&lt; Previous";
			if ($page<$total_p ) $next="<a href='member.area.directory.php?order=$order&page=".($page+1)."&search=$search&photo_only=$photo_only&orx=$orx'>Next &gt;</a>";
			else $next="Next &gt;";
	
			
			for ($i=1; $i<=$total_p; $i++)
			{
				if ($i!=$page)
				 $pages.=" <a href='member.area.directory.php?order=$order&page=$i&search=$search&photo_only=$photo_only&orx=$orx'>$i</a> ";
				else
				$pages.=" <font size=3>$i</font>";
			}
				
		$query="select *  from members where $sea order by $order limit ".(($page-1)*100).", 100";
		$q->query($query);
		
		while ($q->next_record())
		{	
		$query="SELECT country FROM countries WHERE id='".$q->f("country")."'";
		$q2->query($query);
		$q2->next_record();
				
			if ($q->f("p_url1"))
			{
				if (substr($q->f("url1"),0,5)!="http:")
				{
					
					$url="http://".$q->f("url1");
					
				}
				else
					if ($q->f("url1")!="")
						$url=$q->f("url1");
					else
						$url="";
	
			}
			else
			$url="";
			$rows.="<tr valign=top>
						<td >
							<a href=member.area.other.profile.php?id=".$q->f("id")." >".$q->f("id")."</a> &nbsp;
						</td>
	
						<td>
							<b>".$q->f("first_name")." ".$q->f("last_name")." </b> <a href=member.area.other.profile.php?id=".$q->f("id")." >View Profile</a> <br> <a href='".$url."' target=_blank> ".$q->f("url1")."</a>&nbsp;						
						</td>
	
						<td >
							<a href=member.area.other.profile.php?id=".$q->f("id")." >".($q->f("city") ? $q->f("city").", " : "").($q->f("state") ? $q->f("state")." " : "").$q2->f("country")." </a> &nbsp;
						</td >
						
						<td>
	<a href=member.area.write.message.php?id=".$q->f("id")." >Write message</a> &nbsp;					</td>
					</tr>
						";
			
		}
		
		
		
		$t->set_var("prev", $prev);
		$t->set_var("next", $next);
		$t->set_var("pages", $pages);
		$t->set_var("rows", $rows);
		$t->set_var("page", $page);
		$t->set_var("order", $order);
	}else{
		die('You are not allowed to view this file');
	}
	
include("inc.bottom.php");
?>
