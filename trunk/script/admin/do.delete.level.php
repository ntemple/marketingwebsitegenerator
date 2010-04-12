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
	$query="select * from levels where id='$id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("paytype")=="percent_split" || $q->f("paytype")=="full_amount_split")
	$query="delete from levels where id='$id' or id='".($id + 1)."'";
	else $query="delete from levels where id='$id'";
	$q->query($query);
	header("location:levels.php");
?>