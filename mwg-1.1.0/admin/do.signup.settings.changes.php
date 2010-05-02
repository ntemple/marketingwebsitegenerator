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
	$query="select * from signup_settings";
	$q->query($query);
	while ($q->next_record())
	{	
		
		if ($required[$q->f("id")]){
			$atsignup[$q->f("id")] = 1;
			$membersarea[$q->f("id")] = 1;
		}elseif ($atsignup[$q->f("id")]){
			$atsignup[$q->f("id")] = 1;
			$membersarea[$q->f("id")] = 1;
		}
		if (($q->f("field") == "email") || ($q->f("field") == "password")){
			$atsignup[$q->f("id")] = 1;
			$membersarea[$q->f("id")] = 1;
			$required[$q->f("id")] = 1;
		}
		$query="update signup_settings set description='".$_POST[$q->f("field")]."', atsignup='".$atsignup[$q->f("id")]."', required='".$required[$q->f("id")]."', membersarea='".$membersarea[$q->f("id")]."' where id='".$q->f("id")."'";
		$q2->query($query);
		
	}
	header("location:signup.settings.php");
?>