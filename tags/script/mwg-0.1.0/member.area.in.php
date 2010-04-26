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

 
include ("inc.all.php");
if (!$pss) {
	get_logged_info();
	if ($q->f("password")==md5(""))	{
		$t->set_file("content", "create.pass.html");
		include("inc.bottom.php");
		die();
	}
	$q->query("SELECT link FROM menus WHERE alogin='1'");
	$q->next_record();
	if($q->nf() == 0) {
		header("Location: member.area.profile.php");
		die();
	}else {
		header("Location: ".$q->f("link"));
		die();
	}
} else {
	$t->set_file("content", "create.pass.html");
	include("inc.bottom.php");
	die();
}
?>