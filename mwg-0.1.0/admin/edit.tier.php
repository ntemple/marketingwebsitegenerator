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
	$t->set_file("content", "admin.edit.tier.html");
	
	$query="select * from levels where id='$id'";
	$q->query($query);
	$q->next_record();	
	
	$t->set_var("level_id", $q->f("id"));
	$t->set_var("level_value", $q->f("value"));
	$t->set_var("level_jv1", $q->f("jv1"));
	$t->set_var("level_jv2", $q->f("jv2"));
	$t->set_var("tier", $q->f("level"));
	$t->set_var("currency", get_setting('paypal_currency'));
	if ($q->f("paytype")=='') {
		
	} elseif ($q->f("paytype")=='percent') {
		$t->set_var("percentcheck", 'checked');
		$t->set_var("flatcheck", '');
		$t->set_var("percent_value", 'percent');
		$t->set_var("full_amount_value", 'full_amount');
	} elseif ($q->f("paytype")=='full_amount') {
		$t->set_var("percentcheck", '');
		$t->set_var("flatcheck", 'checked');
		$t->set_var("percent_value", 'percent');
		$t->set_var("full_amount_value", 'full_amount');
	}  elseif ($q->f("paytype")=='percent_split') {
		$t->set_var("percentcheck", 'checked');
		$t->set_var("flatcheck", '');
		$t->set_var("percent_value", 'percent_split');
		$t->set_var("full_amount_value", 'full_amount_split');
	} elseif ($q->f("paytype")=='full_amount_split') {
		$t->set_var("percentcheck", '');
		$t->set_var("flatcheck", 'checked');
		$t->set_var("percent_value", 'percent_split');
		$t->set_var("full_amount_value", 'full_amount_split');
	}
	
	$query="select display_name from products where id='".$q->f("product_id")."'";
	$q2->query($query);
	$q2->next_record();
	$t->set_var("product_name", $q2->f("display_name"));
	
	$query="select name from membership where id='".$q->f("membership_id")."'";
	$q2->query($query);
	$q2->next_record();
	$t->set_var("membership_name", $q2->f("name"));
	
	if ($q->f("paytype")=="percent" || $q->f("paytype")=="percent_split")
	{
		
		$t->set_var("st", "");
		$t->set_var("st1", "%");
	}
	if ($q->f("paytype")=="full_amount" || $q->f("paytype")=="full_amount_split")
	{
		
		$t->set_var("st", "");
		$t->set_var("st1", get_setting('paypal_currency'));
	}
	if ($q->f("highcom")==1)
	{
		$t->set_var("highcheck", "checked");
		$t->set_var("high_value", $q->f("highval"));
		$t->set_var("high_days", $q->f("highdays"));
	}
	else
	{
		$t->set_var("highcheck", "");
		$t->set_var("high_value", "");
		$t->set_var("high_days", "");
	}
	$t->set_var("currency", get_setting('paypal_currency'));
	include("inc.bottom.php");
?>