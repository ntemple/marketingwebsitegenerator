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
	$selectate = "";
	if ($view == "all"){
		$q->query("select id, name from membership where active=1");
		
		while($q->next_record()){
			$selectate .= $q->f("id").",";
			
		}
		$selectate = substr($selectate,0,-1);
		
	}else{
		foreach ($membership_id as $membership){
			$selectate .= $membership.",";
		}
		$selectate = substr($selectate,0,-1);
	}
	$q->query("UPDATE settings SET value='".$selectate."' WHERE name='site_overview'");
	
	header ("location: siteoverview.php");
	exit;
	
?>	