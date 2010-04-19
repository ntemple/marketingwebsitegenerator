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
	$query="select id,nid from products".($_GET['oto'] ? ' WHERE nid=\'OTO1\' OR nid=\'OTO2\' OR nid=\'OTO_BCK\' OR nid=\'OTO2_BCK\'' : ' WHERE nid!="OTO1" AND nid!="OTO2" AND nid!="OTO_BCK" AND nid!="OTO2_BCK"');
	$q->query($query);
	while ($q->next_record())
	{
		if ($q->f("id")==$atsignup)
		{
			$query="update products set signup=1 where id='".$q->f("id")."'";
			$q2->query($query);
			$query="update products set physical='".$physical[$q->f("id")]."' where id='".$q->f("id")."'";	$q2->query($query);
			$query="update products set trial_amount='".$trial_amount[$q->f("id")]."', trial_period='".$trial_period[$q->f("id")]."', trial_period_type='".$trial_period_type[$q->f("id")]."', trial='".$_POST['trial_'.$q->f("id")]."', times='".$times[$q->f("id")]."', type='".$type[$q->f("id")]."', period='".$period[$q->f("id")]."', recurring='".$_POST['recurring_'.$q->f("id")]."', display_name='".$name[$q->f("id")]."', nid='".$nid[$q->f("id")]."', nid_clickbank='".$nid_clickbank[$q->f("id")]."', nid_2co='".$nid_2co[$q->f("id")]."', price='".$price[$q->f("id")]."', membership_id='".$membership_id[$q->f("id")]."', clickbank='".$_POST['accept_cb_'.$q->f("id")]."', paypal='".$_POST['accept_paypal_'.$q->f("id")]."', 2co='".$_POST['accept_2co_'.$q->f("id")]."', auth='".$_POST['accept_auth_'.$q->f("id")]."', recurring_auth='".$_POST['recurring_auth_'.$q->f("id")]."', period_auth='".$period_auth[$q->f("id")]."', type_auth='".$type_auth[$q->f("id")]."', times_auth='".$times_auth[$q->f("id")]."', times_trial_auth='".$times_trial_auth[$q->f("id")]."', trial_auth_amount='".$trial_auth_amount[$q->f("id")]."', start_auth_subscr='".$start_auth_subscr[$q->f("id")]."'  where id='".$q->f("id")."'";
			$q2->query($query);
		} elseif ($_GET['oto']) {
			if ($q->f('nid') == 'OTO1' && $nid[$q->f("id")] == 'OTO1'){
				$query="update products set physical='".$physical[$q->f("id")]."' where id='".$q->f("id")."'";	$q2->query($query);
				$query="update products set trial_amount='".$trial_amount[$q->f("id")]."', trial_period='".$trial_period[$q->f("id")]."', trial_period_type='".$trial_period_type[$q->f("id")]."', trial='".$_POST['trial_'.$q->f("id")]."', times='".$times[$q->f("id")]."', type='".$type[$q->f("id")]."', period='".$period[$q->f("id")]."', recurring='".$_POST['recurring_'.$q->f("id")]."', display_name='".$name[$q->f("id")]."', nid='".$nid[$q->f("id")]."', nid_clickbank='".$nid_clickbank[$q->f("id")]."', nid_2co='".$nid_2co[$q->f("id")]."', price='".$price[$q->f("id")]."', membership_id='".$membership_id[$q->f("id")]."', clickbank='".$_POST['accept_cb_'.$q->f("id")]."', paypal='".$_POST['accept_paypal_'.$q->f("id")]."', 2co='".$_POST['accept_2co_'.$q->f("id")]."', auth='".$_POST['accept_auth_'.$q->f("id")]."', recurring_auth='".$_POST['recurring_auth_'.$q->f("id")]."', period_auth='".$period_auth[$q->f("id")]."', type_auth='".$type_auth[$q->f("id")]."', times_auth='".$times_auth[$q->f("id")]."', times_trial_auth='".$times_trial_auth[$q->f("id")]."', trial_auth_amount='".$trial_auth_amount[$q->f("id")]."', start_auth_subscr='".$start_auth_subscr[$q->f("id")]."', signup=0 where id='".$q->f("id")."'";
				$q2->query($query);
			}elseif ($q->f('nid') == 'OTO2' && $nid[$q->f("id")] == 'OTO2'){
				$query="update products set physical='".$physical[$q->f("id")]."' where id='".$q->f("id")."'";	$q2->query($query);
				$query="update products set trial_amount='".$trial_amount[$q->f("id")]."', trial_period='".$trial_period[$q->f("id")]."', trial_period_type='".$trial_period_type[$q->f("id")]."', trial='".$_POST['trial_'.$q->f("id")]."', times='".$times[$q->f("id")]."', type='".$type[$q->f("id")]."', period='".$period[$q->f("id")]."', recurring='".$_POST['recurring_'.$q->f("id")]."', display_name='".$name[$q->f("id")]."', nid='".$nid[$q->f("id")]."', nid_clickbank='".$nid_clickbank[$q->f("id")]."', nid_2co='".$nid_2co[$q->f("id")]."', price='".$price[$q->f("id")]."', membership_id='".$membership_id[$q->f("id")]."', clickbank='".$_POST['accept_cb_'.$q->f("id")]."', paypal='".$_POST['accept_paypal_'.$q->f("id")]."', 2co='".$_POST['accept_2co_'.$q->f("id")]."', auth='".$_POST['accept_auth_'.$q->f("id")]."', recurring_auth='".$_POST['recurring_auth_'.$q->f("id")]."', period_auth='".$period_auth[$q->f("id")]."', type_auth='".$type_auth[$q->f("id")]."', times_auth='".$times_auth[$q->f("id")]."', times_trial_auth='".$times_trial_auth[$q->f("id")]."', trial_auth_amount='".$trial_auth_amount[$q->f("id")]."', start_auth_subscr='".$start_auth_subscr[$q->f("id")]."', signup=0 where id='".$q->f("id")."'";
				$q2->query($query);
			}elseif ($q->f('nid') == 'OTO_BCK' && $nid[$q->f("id")] == 'OTO_BCK'){	
				$query="update products set physical='".$physical[$q->f("id")]."' where id='".$q->f("id")."'";	$q2->query($query);
				$query="update products set trial_amount='".$trial_amount[$q->f("id")]."', trial_period='".$trial_period[$q->f("id")]."', trial_period_type='".$trial_period_type[$q->f("id")]."', trial='".$_POST['trial_'.$q->f("id")]."', times='".$times[$q->f("id")]."', type='".$type[$q->f("id")]."', period='".$period[$q->f("id")]."', recurring='".$_POST['recurring_'.$q->f("id")]."', display_name='".$name[$q->f("id")]."', nid='".$nid[$q->f("id")]."', nid_clickbank='".$nid_clickbank[$q->f("id")]."', nid_2co='".$nid_2co[$q->f("id")]."', price='".$price[$q->f("id")]."', membership_id='".$membership_id[$q->f("id")]."', clickbank='".$_POST['accept_cb_'.$q->f("id")]."', paypal='".$_POST['accept_paypal_'.$q->f("id")]."', 2co='".$_POST['accept_2co_'.$q->f("id")]."', auth='".$_POST['accept_auth_'.$q->f("id")]."', recurring_auth='".$_POST['recurring_auth_'.$q->f("id")]."', period_auth='".$period_auth[$q->f("id")]."', type_auth='".$type_auth[$q->f("id")]."', times_auth='".$times_auth[$q->f("id")]."', times_trial_auth='".$times_trial_auth[$q->f("id")]."', trial_auth_amount='".$trial_auth_amount[$q->f("id")]."', start_auth_subscr='".$start_auth_subscr[$q->f("id")]."', signup=0 where id='".$q->f("id")."'";
				$q2->query($query);
			}elseif ($q->f('nid') == 'OTO2_BCK' && $nid[$q->f("id")] == 'OTO2_BCK'){	
				$query="update products set physical='".$physical[$q->f("id")]."' where id='".$q->f("id")."'";	$q2->query($query);
				$query="update products set trial_amount='".$trial_amount[$q->f("id")]."', trial_period='".$trial_period[$q->f("id")]."', trial_period_type='".$trial_period_type[$q->f("id")]."', trial='".$_POST['trial_'.$q->f("id")]."', times='".$times[$q->f("id")]."', type='".$type[$q->f("id")]."', period='".$period[$q->f("id")]."', recurring='".$_POST['recurring_'.$q->f("id")]."', display_name='".$name[$q->f("id")]."', nid='".$nid[$q->f("id")]."', nid_clickbank='".$nid_clickbank[$q->f("id")]."', nid_2co='".$nid_2co[$q->f("id")]."', price='".$price[$q->f("id")]."', membership_id='".$membership_id[$q->f("id")]."', clickbank='".$_POST['accept_cb_'.$q->f("id")]."', paypal='".$_POST['accept_paypal_'.$q->f("id")]."', 2co='".$_POST['accept_2co_'.$q->f("id")]."', auth='".$_POST['accept_auth_'.$q->f("id")]."', recurring_auth='".$_POST['recurring_auth_'.$q->f("id")]."', period_auth='".$period_auth[$q->f("id")]."', type_auth='".$type_auth[$q->f("id")]."', times_auth='".$times_auth[$q->f("id")]."', times_trial_auth='".$times_trial_auth[$q->f("id")]."', trial_auth_amount='".$trial_auth_amount[$q->f("id")]."', start_auth_subscr='".$start_auth_subscr[$q->f("id")]."', signup=0 where id='".$q->f("id")."'";
				$q2->query($query);
			}
		}else{
			if ($atsignup[$q->f("id")]!=0 || $atsignup[$q->f("id")]!='')
			{
				$product_at_signup=1;
			}
			else
			{
				$product_at_signup=0;
			}
			$query="update products set physical='".$physical[$q->f("id")]."' where id='".$q->f("id")."'";	$q2->query($query);
			$query="update products set trial_amount='".$trial_amount[$q->f("id")]."', trial_period='".$trial_period[$q->f("id")]."', trial_period_type='".$trial_period_type[$q->f("id")]."', trial='".$_POST['trial_'.$q->f("id")]."', times='".$times[$q->f("id")]."', type='".$type[$q->f("id")]."', period='".$period[$q->f("id")]."', recurring='".$_POST['recurring_'.$q->f("id")]."', display_name='".$name[$q->f("id")]."', nid='".$nid[$q->f("id")]."', nid_clickbank='".$nid_clickbank[$q->f("id")]."', nid_2co='".$nid_2co[$q->f("id")]."', price='".$price[$q->f("id")]."', membership_id='".$membership_id[$q->f("id")]."', clickbank='".$_POST['accept_cb_'.$q->f("id")]."', paypal='".$_POST['accept_paypal_'.$q->f("id")]."', 2co='".$_POST['accept_2co_'.$q->f("id")]."', auth='".$_POST['accept_auth_'.$q->f("id")]."', recurring_auth='".$_POST['recurring_auth_'.$q->f("id")]."', period_auth='".$period_auth[$q->f("id")]."', type_auth='".$type_auth[$q->f("id")]."', times_auth='".$times_auth[$q->f("id")]."', times_trial_auth='".$times_trial_auth[$q->f("id")]."', trial_auth_amount='".$trial_auth_amount[$q->f("id")]."', start_auth_subscr='".$start_auth_subscr[$q->f("id")]."', signup='$product_at_signup' where id='".$q->f("id")."'";
			
			$q2->query($query);
			$query="update products set physical='".$physical[$q->f("id")]."' where id='".$q->f("id")."'";	$q2->query($query);
		}
	}
	if ($_GET['oto']){
		header("location:oto.php");
	}else header("location:products.php");
?>
