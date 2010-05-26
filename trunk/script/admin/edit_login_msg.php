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
  
	$t->set_file("content", "admin.edit_login_msg.html");
	$query="select message from after_login WHERE id='$id'";
	$q->query($query);	
	$q->next_record();
	$t->set_var("message",stripslashes($q->f('message')));
	$t->set_var("id",$id);
	
	$t->set_file("main", "admin.main.empty.html");
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main"); 
  MWG::getInstance()->response->initEditor();
