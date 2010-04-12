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
	$qw=new CDB;
	$t->set_file("content", "admin.members.sellers.html");	
	$t->set_file("rows_k", "admin.members.sellers.row.html");
	if ($name) {
		$search="AND (";
		$name_exp=explode(" ", $name);
		foreach ($name_exp as $value_exp) {
			$search.="first_name='$value_exp' OR last_name='$value_exp' OR email LIKE '%$value_exp%' OR members.id='$value_exp' OR ";
		}
		$search.="members.id=1)";
	} else {
		$search="";
	}
	
	
	$query="SELECT count(*) AS nr_sales, affiliate_id, email, first_name, last_name, members.id FROM `session`, members WHERE paid=1 AND affiliate_id!='0' AND affiliate_id!=member_id AND affiliate_id=members.id $search GROUP BY affiliate_id";
	$qw->query($query);
	$qw->next_record();
	$total_adds=$qw->nf();
	$perpage=20;
	$pages=$total_adds/$perpage;
	$page_exp=explode(".", $pages);
	if (!$page_exp[1]) {
	 	$pages=$page_exp[0];
	 }else {
	 	$pages=$page_exp[0]+1;
	 }
	
	if (!$page) {
		$page=1;
	}
	
	$file=$_SERVER['PHP_SELF']."?name=$name";
	
	if ($pages>1) {
	for ($i=1;$i<$pages+1;$i++){
		if ($i==1 && $page!=1) $pagelist.="[<a href=$file&page=".$i.$get.">"."First"."</a>]";
		if ($i==1 && $page!=1 && $pages>1) {$prev=$page-1; $pagelist.="[<a href=$file&page="."$prev.$get".">"."<< Previous"."</a>]";}
		if ($i<=$pages-1 && $i!=1 && $i==$page-1) $pagelist.="[<a href=$file&page=".$i.$get.">"."$i"."</a>]";
		if ($i<=$pages-1 && $i!=1 && $i<$page-1 && $i>$page-10) $pagelist.="[<a href=$file&page=".$i.$get.">".$i."</a>]";
		if ($i==$page) $pagelist.="<b> $i </b>";
		if ($i<=$pages-1 && $i!=$pages && $i>$page+1 && $i<$page+10) $pagelist.="[<a href=$file&page=".$i.$get.">".$i."</a>]";
		if ($i<=$pages-1 && $i!=$pages && $i==$page+1) $pagelist.="[<a href=$file&page=".$i.$get.">".$i."</a>]";
		if ($i==$pages && $page!=$pages && $pages>1) {$next=$page+1; $pagelist.="[<a href=$file&page=".$next.$get.">"."Next >>"."</a>]";}
		if ($i==$pages && $page!=$pages) $pagelist.="[<a href=$file&page=".$i.$get.">"."Last"."</a>]";
		}
	}
	$t->set_var("pages", $pagelist);
	$limit_start=$perpage*($page-1);
	$limit_end=$perpage;
	
	
	$query="SELECT count(*) AS nr_sales, affiliate_id, email, first_name, last_name, members.id FROM `session`, members WHERE paid=1 AND affiliate_id!='0' AND affiliate_id!=member_id AND affiliate_id=members.id $search GROUP BY affiliate_id ORDER BY nr_sales DESC LIMIT $limit_start, $limit_end";
	$q2->query($query);
	$i=1;
	while ($q2->next_record()) {
		$t->set_var("position", ((($page-1)*$perpage)+$i));
		$t->set_var("id", $q2->f('id'));
		$t->set_var("name", $q2->f('first_name')." ".$q2->f('last_name'));
		$t->set_var("email", $q2->f('email'));
		$t->set_var("refferals", $q2->f('nr_sales'));
		$t->parse("rows", "rows_k", true);
		$i++;
	}
	if ($q2->nf()<1) {
		$t->set_var("rows", "<td colspan='5'><center><font color='red'><b>No sales found!</b></font></center></td>");
	}
	
	include('inc.bottom.php');
?>