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


	include ("inc.top.php");
	get_logged_info();
	$member_id=$q->f("id");
	$query="select * from member_journal where member_id='$member_id' and id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_file("content", "edit_member_notes.html");
	$t->set_var("subject", $q->f("subject"));
	$t->set_var("body", $q->f("body"));
	$t->set_var("note_id", $q->f("id"));
	include ("inc.bottom.php");
?>