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
	
	
	// download bonuses page
	$q->query("SELECT max(rank) AS rank_max FROM membership");
	$q->next_record();
	
	$query="insert into membership (name, rank) values ('$membership_name', '".($q->f("rank_max")+1)."')";
	$q->query($query);
	$mid=mysql_insert_id($q->link_id());
	$mname=$membership_name;
	$filename="member.area.membership.dw.".$mid;
	
	if (is_file("../templates/".$filename.".ag.html"))
	{
		die("../templates/".$filename.".ag.html file already exists, not overwriting, please enter another filename");
	}
	FFileWriteNew("../templates/".$filename.".ag.html", $membership_file, "w");
	$query="insert into templates (id, filename, name, description) values
			(NULL, '".$filename.".ag.html', 'Template Bonus for membership $mname', '$title')";
	$q->query($query);
	$tid=mysql_insert_id($q->link_id());
	// salespage
	$filename="member.area.membership.sl.".$mid;
	
	if (is_file("../templates/".$filename.".ag.html"))
	{
		die("../templates/".$filename.".ag.html file already exists, not overwriting, please enter another filename");
	}
	FFileWriteNew("../templates/".$filename.".ag.html", $membership_file, "w");
	$query="insert into templates (id, filename, name, description) values
			(NULL, '".$filename.".ag.html', 'Template Salespage for $mname', '$title')";
	$q->query($query);
	$tid2=mysql_insert_id($q->link_id());
	// the new menu item
	
	
	$query="update membership set template_id='$tid', template_id2='$tid2', promo_code='$promo_code' where id='$mid'";
	$q->query($query);
	header("Location: membership.php");
	
?>