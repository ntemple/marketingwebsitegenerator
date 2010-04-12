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
	$q2=new Cdb;
	
	$q->query("SELECT * FROM after_login");
	while ($q->next_record()){
		
		$memberships = '';
	
		if ($_POST['msg_membership_'.$q->f('id')] == 'all'){
			$memberships = 'all';
		}elseif ($_POST['msg_membership_'.$q->f('id')] == 'just'){
			if (isset($_POST['membership_'.$q->f('id')])){
				foreach ($_POST['membership_'.$q->f('id')] as $key=>$value){
					
					if ($value){
						$memberships .= "$value,";
					}
				}
			}
			$memberships = substr($memberships,0,-1);
		}
		
		$q2->query("UPDATE after_login SET nr_days='".$_POST['nr_days_'.$q->f('id')]."', count='".$_POST['count_'.$q->f('id')]."', active='".$_POST['active_'.$q->f('id')]."', membership='$memberships' WHERE id='".$q->f('id')."'");
	}
	header("Location: login_msg.php");
?>