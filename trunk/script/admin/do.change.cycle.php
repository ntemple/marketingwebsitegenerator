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
	$q2=new cdb;
	$query="select * from cycle where cycle='$cycle'";
	$q->query($query);
	while ($q->next_record())
	{
		$query="update cycle set cycle='$cycle_name', text='".$_POST["cycle_values_".$q->f("id")]."' where id='".$q->f("id")."'";
		$q2->query($query);
	}
	header("location:cycler.php");
?>	