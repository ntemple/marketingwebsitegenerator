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
	$t->set_file("content", "admin.css.html");
	FFileRead("../css/butterfly.css", $css);
	preg_match("/(\d+)px/", $css, $match);
	$t->set_var("size", $match[1]);
	preg_match("/(\w+)\;/", $css, $match);
	$t->set_var("font", $match[1]);
	$t->set_var($match[1]."select", "selected");
	include ("inc.bottom.php");
?>
