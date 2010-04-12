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
	$q2=new Cdb;
	$t->set_file("content", "admin.siteoverview.html");
	$t->set_file("membershiplist", "admin.siteoverview.checkboxes.html");
	$t->set_file("upgradeslist", "admin.siteoverview.upgrades.html");
	$now=time();
	$nowh=date("G");
	$today=$now-($nowh*3600);
	$query="select id from members where s_date > $today and s_date < $now";
	$q->query($query);
	$q->next_record();
	$t->set_var("new", $q->nf());
	$yesterday=$today-(24*3600);
	$query="select id from members where s_date > $yesterday and s_date < $today";
	$q->query($query);
	$q->next_record();
	$t->set_var("newy", $q->nf());
	$query="select count(*) as member_count from members";
	$q->query($query);
	$q->next_record();
	$t->set_var("total_members", $q->f("member_count"));
	$query="SELECT count(*) as a, membership_id FROM `members` where upgrade_date>$today and upgrade_date<$now group by membership_id";
	
	$q->query($query);
	$i=0;$membership_id='';
	while ($q->next_record())
	{
		$query="select name from membership where id='".$q->f("membership_id")."'";
		$q2->query($query);
		$q2->next_record();
		$t->set_var("membership", "Upgrades to ".$q2->f("name")." today:");
		$t->set_var("no", $q->f("a"));
		$t->parse("upgrade_list", "upgradeslist", true);
		
		
	}
	$query="SELECT count(*) as a, membership_id FROM `members` where upgrade_date>$yesterday and upgrade_date<$today group by membership_id";
	
	$q->query($query);
	$i=0;$membership_id='';
	while ($q->next_record())
	{
		$query="select name from membership where id='".$q->f("membership_id")."'";
		$q2->query($query);
		$q2->next_record();
		$t->set_var("membership", "Upgrades to ".$q2->f("name")." yesterday:");
		$t->set_var("no", $q->f("a"));
		$t->parse("upgrade_list", "upgradeslist", true);
		
		
	}
	
	$t->set_var("membership", "&nbsp;");
	$t->set_var("no", "&nbsp;");
	$t->parse("upgrade_list", "upgradeslist", true);
	
	$query="select * from membership";
	$q->query($query);
	while ($q->next_record())
	{
		$query="select count(*) as a from members where membership_id='".$q->f("id")."'";
		$q2->query($query);
		$q2->next_record();
		$t->set_var("membership", "Total ".$q->f("name")." members:");
		$t->set_var("no", $q2->f("a"));
		$t->parse("upgrade_list", "upgradeslist", true);
	}
	$query="select COUNT(*) AS total from membership where active=1";
	$q->query($query);
	$q->next_record();
	$tot_membership = $q->f("total");
	$cele_selectate = explode(",",get_setting('site_overview'));
	
	if (count($cele_selectate) == $tot_membership){
		$disabled = 1;
		$t->set_var("checked_all", "checked");
	}else{
		$disabled = 0;
		$t->set_var("checked_just", "checked");
	}
		
	$query="select id, name from membership where active=1";
	$q->query($query);
	while($q->next_record())
	{	
		if (strpos(get_setting('site_overview'),$q->f("id")) === false){
			$t->set_var("checked", "");
		}else 
			$t->set_var("checked", "checked");
		if ($disabled){
			$t->set_var("disabled", "disabled");
		}else 
			$t->set_var("disabled", "");
		
		$t->set_var("membership_id", $q->f("id"));
		$t->set_var("membership_name", $q->f("name"));
		$t->parse("membership_list", "membershiplist", true);
	}
	
	
	include ("inc.bottom.php");
?>