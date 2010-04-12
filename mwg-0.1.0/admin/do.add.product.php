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
	$query="select * from products where nid='$nid'";
	$q->query($query);
	if ($q->nf()==0) 
	{
		if ($recurring==1){
			if ($trial==1) $query="insert into products (price, membership_id, nid, display_name, recurring, period, type, times, trial, trial_amount, trial_period, trial_period_type, nid_clickbank, nid_2co, paypal, clickbank, 2co) values ('$price', '$membership_id', '".addslashes($nid)."', '".addslashes($display_name)."','$recurring','$period', '$type', '$times', '$trial', '$trial_amount', '$trial_period', '$trial_period_type', '$nid_clickbank', '$nid_2co', '$paypal', '$cb_nid', '$_2co_nid')";
			else
			$query="insert into products (price, membership_id, nid, display_name, recurring, period, type, times, nid_clickbank, nid_2co, paypal, clickbank, 2co) values ('$price', '$membership_id', '".addslashes($nid)."', '".addslashes($display_name)."','$recurring','$period', '$type', '$times', '$nid_clickbank', '$nid_2co', '$paypal', '$cb_nid', '$_2co_nid')";
		}else
			$query="insert into products (price, membership_id, nid, display_name, nid_clickbank, nid_2co, paypal, clickbank, 2co) values ('$price', '$membership_id', '".addslashes($nid)."', '".addslashes($display_name)."', '$nid_clickbank', '$nid_2co', '$paypal', '$cb_nid', '$_2co_nid')";
		$q->query($query);
	}
	header("location:products.php");
?>