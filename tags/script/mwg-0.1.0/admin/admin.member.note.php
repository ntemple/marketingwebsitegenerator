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
	$t->set_file("content", "admin.member.note.html");
	
	if ($_GET['action'] == 'add'){
		$t->set_var("action","do.add.member.note.php?member_id=".$_GET['member_id']);
		$t->set_var("writer", '');
		$t->set_var("message", '');
		$t->set_var("save_name", 'Submit');
	}elseif ($_GET['action'] == 'edit'){
		$t->set_var("action","do.edit.member.note.php?note_id=".$_GET['note_id']);
		$q->query("SELECT message, writer FROM member_notes WHERE id='".$_GET['note_id']."'");
		$q->next_record();
		$t->set_var("writer", $q->f("writer"));
		$t->set_var("message", $q->f("message"));
		$t->set_var("save_name", 'Save Note');
	}
	
		$t->pparse("out", "content");
?>