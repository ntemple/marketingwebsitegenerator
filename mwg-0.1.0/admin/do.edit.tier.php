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
	$q2=new cdb;
	$query="update levels set paytype='$paytype' where id='$id'";
	$q2->query($query);
	$query="select * from levels where id='$id'";
	$q->query($query);
	$q->next_record();
	
	if ($q->f("paytype")=="percent_split")
	{
		$next_val=100-$value;
		$jv12=100-$jv1;
		$jv22=100-$jv2;
		$query="update levels set value='$value', jv1='$jv1', jv2='$jv2', highcom='$highcomms', highval='$highval', highdays='$highdays' where id='$id'";
		$q2->query($query);
		$id2=$id+1;
		$query="update levels set value='$next_val', jv1='$jv12', jv2='$jv22', highcom='$highcomms', highval='".(100-$highval)."', highdays='$highdays' where id='$id2'";
		$q2->query($query);
		
	}
	
	if ($q->f("paytype")=="full_amount_split")
	{
		$query="select price from products where id='".$q->f("product_id")."'";
		$q2->query($query);
		$q2->next_record();
		$price=$q2->f("price");
		
		$next_val=$price-$value;
		$jv12=$price-$jv1;
		$jv22=$price-$jv2;
		$query="update levels set value='$value', jv1='$jv1', jv2='$jv2', highcom='$highcomms', highval='$highval', highdays='$highdays' where id='$id'";
		$q2->query($query);
		$id2=$id+1;
		$query="update levels set value='$next_val', jv1='$jv12', jv2='$jv22', highcom='$highcomms', highval='".($price-$highval)."', highdays='$highdays' where id='$id2'";
		$q2->query($query);
	}
	
	if ($q->f("paytype")=="full_amount" || $q->f("paytype")=="percent")
	{
		$query="update levels set value='$value', jv1='$jv1', jv2='$jv2', highcom='$highcomms', highval='$highval', highdays='$highdays' where id='$id'";
		$q2->query($query);
	}
	header("location: levels.php");
?>