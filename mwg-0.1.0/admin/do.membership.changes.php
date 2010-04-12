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
	$q2=new CDB;
	switch ($option)
	{
		case "show_promo_signup":
			set_setting("show_promo_signup",1);
			set_setting("show_promo_profile", 0);
		break;
		case "show_promo_profile":
			set_setting("show_promo_signup",0);
			set_setting("show_promo_profile", 1);
		break;
		case "show_promo_both":
			set_setting("show_promo_signup",1);
			set_setting("show_promo_profile", 1);
		break;
		case "show_promo_none":
			set_setting("show_promo_signup",0);
			set_setting("show_promo_profile", 0);
		break;
	}
	$query="select id, name, template_id, template_id2 from membership";
	$q->query($query);
	while ($q->next_record())
	{
		
		if ($_POST["display_to".$q->f("id")]!="")
		{
			$to_display='|';
			foreach ($_POST["display_to".$q->f("id")] as $key => $value)
			{
				$to_display.=$value."|";
			}
		}
		
		$updatequery="update templates set name='Template Salespage for ".$name[$q->f("id")]."' where id='".$q->f("template_id2")."'";
		$q2->query($updatequery);
		$updatequery="update templates set name='Template Bonus for membership ".$name[$q->f("id")]."' where id='".$q->f("template_id")."'";
		$q2->query($updatequery);
		
		$updatequery="update membership set ref_no='".$referral[$q->f("id")]."', name='".$name[$q->f("id")]."', promo_code='".$promo[$q->f("id")]."', shown_to='$to_display' where id='".$q->f("id")."'";
		$to_display='';
		$q2->query($updatequery);
				
	}
	header("location:membership.php");
?>