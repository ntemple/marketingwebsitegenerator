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
	get_logged_info();
	if (!$l) {
		$l=$q->f("membership_id");
	}
	if (!isset($f) && isset($l)) {
	$member_membership_id=$q->f("membership_id");
	$member_history=explode(",", $q->f("history"));
	$i=0;
	while ($i<count($member_history)) {
		if ($member_history[$i]==$l) {
			$query="select * from membership where id='".$l."'";
		}
		$i++;
	}
		}else{ 
	$query="select * from membership where id='".$q->f("membership_id")."'";
		}
	$q->query($query);
	$q->next_record();
	$query="select * from templates where id='".$q->f("template_id")."'";
	$q->query($query);
	$q->next_record();
	if ($q->nf()<1) {
		die("<center><font color='red'><b>You don't have required membership to access this page!</font></b></center>");
	}
	$t->set_file("content",$q->f("filename"));
	get_logged_info();
	replace_tags_t($q->f("id"), $t);
	
include("inc.bottom.php");
?>