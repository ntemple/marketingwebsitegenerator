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
	$q2= new Cdb;
	
	$query="update products set cb_but=0 where cb_but='$img_id2' and id='$id'";
	$q->query($query);
	
	$query="update products set 2co_but=0 where 2co_but='$img_id2' and id='$id'";
	$q->query($query);
	$query="update products set pp_but=0 where pp_but='$img_id2' and id='$id'";
	$q->query($query);
	$query="delete from buybuttons where id = '$img_id2'";
	$q->query($query);
	
	header("location: products.buybutton.settings.php?id=".$id);
	
	
	
	
?>