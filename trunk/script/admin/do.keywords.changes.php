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
	if ($from_html){
		$q->query("UPDATE settings SET description='from html' WHERE name='meta-description'");
	}else{
		$q->query("UPDATE settings SET value='$description', description='' WHERE name='meta-description'");
	}
	$what = array ("/,\s+/","/\n*?/","/\s+,/");
	$with = array (",","",",");
	$keywords = preg_replace($what,$with,$keywords);
	$keywords = trim($keywords);
	$q->query("UPDATE settings SET value='$keywords' WHERE name='keywords'");
	
	header("location:keywords.php");
?>