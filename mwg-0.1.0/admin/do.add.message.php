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
	$memberships = '';
	
	if ($msg_membership == 'all'){
		$memberships = 'all';
	}elseif ($msg_membership == 'just'){
		foreach ($membership as $key=>$value){
			if ($value){
				$memberships .= "$value,";
			}
		}
	}
	if ($memberships!='all') $memberships = substr($memberships,0,-1);
	$q->query("INSERT INTO after_login SET nr_days='$nr_days', count='$count', message='".addslashes($contentb)."', active='$active', membership='$memberships'");
	header("Location: login_msg.php?menu=settings");
?>
