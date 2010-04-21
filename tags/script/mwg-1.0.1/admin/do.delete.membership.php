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
	$q=new Cdb;
	$query="select name, id from membership where id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_var("membership", $q->f("name"));
	$t->set_var("id", $q->f("id"));
	$query="select count(*) as a from members where membership_id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_file("content", "admin.delete.membership.html");
	$t->set_var("members", $q->f("a"));
	
	$query="select * from membership where id!='$id'";
	$q->query($query);
	while ($q->next_record())
	{
		$options.='<option value="'.$q->f("id").'">'.$q->f("name").'</option>
		';
	}
	$t->set_var("memberships", $options);
	
	include("inc.bottom.php");
	
?>