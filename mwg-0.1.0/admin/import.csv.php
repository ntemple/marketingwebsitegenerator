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
	if($_GET['err'] == 1){
		$t->set_var("error","Error: duplicate field name(you selected two columns to be inserted in to the same database field)");
	}elseif ($_GET['err'] == 2){	
		$t->set_var("error","Error: error in csv file");
	}else{	
		$t->set_var("error","");
	}
	
	$t->set_file("content", "admin.import.csv.html");
	
	include ("inc.bottom.php");
?>