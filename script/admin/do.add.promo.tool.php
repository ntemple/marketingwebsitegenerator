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
	
	$q->query("SELECT MAX(rank) AS max FROM promo_tools");
	$q->next_record();
	
	$query="insert into promo_tools (id, category, content, template, rank) values (NULL, '$category', '$contentb','$template','".($q->f("max")+1)."')";
	$q->query($query);
	header("location:promo.tools.php");
	include('inc.bottom.php');
?>