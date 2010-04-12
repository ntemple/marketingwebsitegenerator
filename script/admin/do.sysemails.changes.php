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
	//Building Query for Settings Update
	$q2=new CDB;
	
	$i = 0;
	foreach ($_POST as $variable){
		$i = 1;
	}
	
	$k=1;
	
	$query="select * from settings where name like '%_email%' and box_type!='hidden' and id!=13 and id!=9 order by cat, rank";
	$q->query($query);
	if ($i){
		while ($q->next_record())
		{
				$updatequery="update settings set value='".addslashes($_POST[$q->f("name")])."' where name='".$q->f("name")."'";
				$q2->query($updatequery);
			
				
		}
	}
	header("location:sysemails.php");
?>