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
	
	$query="insert into faq (id, faq_category, question, answer, position) values (NULL, '".addslashes($faq_category)."', '".addslashes($question)."','".addslashes($answer)."', '$position')";
	$q->query($query);
	header("location:faq.php");
	
	include('inc.bottom.php');
?>