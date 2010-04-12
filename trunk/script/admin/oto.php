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
$q2=new CDB;
$t->set_file("content", "admin.oto.html");
$t->set_file("membershiplist", "admin.membership.select.html");
$t->set_file("membershiplista", "admin.membership.select.html");
$t->set_file("productlist", "admin.oto.item.html");
$chck_funtions = '';
$physical_functions = '';
$query="select products.* from products, membership where (nid='OTO1' OR nid='OTO2' OR nid='OTO_BCK' OR nid='OTO2_BCK') AND membership.id=products.membership_id and membership.active=1";
$q->query($query);
while ($q->next_record())
{
	if ($q->f("paypal")!=1) {
		$query="update products set physical='0' where id='".$q->f("id")."'";	$q2->query($query);
	}
}
$query="select products.* from products, membership where (nid='OTO1' OR nid='OTO2' OR nid='OTO_BCK' OR nid='OTO2_BCK') AND membership.id=products.membership_id and membership.active=1";
$q->query($query);
while ($q->next_record())
{
	$t->set_var("product_id", $q->f("id"));
	$physical_functions.="if (document.getElementById('physical[".$q->f("id")."]').checked != true) {document.getElementById('shipping_table_".$q->f("id")."').disabled=true}else document.getElementById('shipping_table_".$q->f("id")."').disabled=false; ";
	$t->set_var("product_name", stripslashes($q->f("display_name")));
	$t->set_var("product_nid", stripslashes($q->f("nid")));
	$t->set_var("product_nid_clickbank",($q->f("nid_clickbank")));
	$t->set_var("product_nid_2co",($q->f("nid_2co")));
	$t->set_var("product_price", $q->f("price"));
	if ($q->f("physical")==1) {
		$t->set_var("checked_physical", "checked");
	}else {
		$t->set_var("checked_physical", "");
	}
	if ($q->f("paypal")==1)
	{
		$t->set_var("chck_paypal", "checked");
		$t->set_var("disabled_physical", "");
		$t->set_var("physical_message", "");
	}else{
		$t->set_var("chck_paypal", "");
		$t->set_var("disabled_physical", "disabled=\"disabled\"");
		$t->set_var("physical_message", "<b>*Promote this product with Paypal to activate fields!</b>");
	}
	if ($q->f("auth")==1)
	{
			
		$t->set_var("auth_div_display", "");
		if ($q->f("recurring_auth") == 1) {
			$t->set_var("auth2_div_display", "");
			$t->set_var("recurring_chck_auth", "checked");
			if ($q->f("type_auth") == "days") $days_r = "selected";
			if ($q->f("type_auth") == "months") $months_r = "selected";
			$t->set_var("period_auth", $q->f("period_auth"));
			$type_auth = '<option value="days" '.$days_r.'>Days</option>
	
					<option value="months" '.$months_r.'>Months</option>';
			$t->set_var("type_auth", $type_auth);
			$t->set_var("times_auth", $q->f("times_auth"));
			$t->set_var("trial_auth_amount", $q->f("trial_auth_amount"));
			$t->set_var("times_trial_auth", $q->f("times_trial_auth"));
			$t->set_var("start_auth_subscr", $q->f("start_auth_subscr"));
		} else {
			$t->set_var("auth2_div_display", "none");
			$t->set_var("recurring_chck_auth", "");
			$t->set_var("period_auth", '');
			$t->set_var("times_auth", "");
			$type_auth = '<option value="days">Days</option>
                <option value="months">Months</option>';
			$t->set_var("type_auth", $type_auth);
			$t->set_var("trial_auth_amount", '0');
			$t->set_var("times_trial_auth", '0');
			$t->set_var("start_auth_subscr", '0');
		}
		$t->set_var("chck_auth", "checked");
	}else{
		$t->set_var("auth_div_display", "none");
		$t->set_var("auth2_div_display", "none");
		$t->set_var("recurring_chck_auth", "");
		$t->set_var("period_auth", '');
		$t->set_var("times_auth", "");
		$type_auth = '<option value="days">Days</option>
                <option value="months">Months</option>';
		$t->set_var("type_auth", $type_auth);
		$t->set_var("trial_auth_amount", '0');
		$t->set_var("times_trial_auth", '0');
		$t->set_var("start_auth_subscr", '0');
		$t->set_var("chck_auth", "");
		$t->set_var("chck_auth", "");
	}
	if ($q->f("clickbank")==1 && $q->f("nid_clickbank")!= '0')
	{
		$chck_funtions .= "display_tr(document.getElementById('accept_cb_".$q->f("id")."'));";
		$t->set_var("chck_cb", "checked");
	}else{
		$t->set_var("chck_cb", "");
	}
	if ($q->f("2co")==1 && $q->f("nid_2co") != '0')
	{
		$chck_funtions .= "display_tr(document.getElementById('accept_2co_".$q->f("id")."'));";
		$t->set_var("chck_2co", "checked");
	}else{
		$t->set_var("chck_2co", "");
	}
	if ($q->f("recurring")==1)
	{
		$chck_funtions .= "display_tr(document.getElementById('recurring_".$q->f("id")."'));";
			
		$t->set_var("recurring", "Yes");
		$t->set_var("recurring_chck", "checked");
		if ($q->f("type")=="D") $days_r="selected";
		if ($q->f("type")=="M") $months_r="selected";
		if ($q->f("type")=="Y") $years_r="selected";
		$t->set_var("period",$q->f("period"));
		$type = '<option value="D" '.$days_r.'>Days</option>
	          <option value="M" '.$months_r.'>Months</option>
	          <option value="Y" '.$years_r.'>Years</option>';
		$t->set_var("type",$type);
		$t->set_var("times", $q->f("times"));
	}
	else
	{
		$t->set_var("recurring_chck", "");
		$t->set_var("recurring", "No");
		$t->set_var("period",'');
		$t->set_var("times", "");
		$type = '<option value="D">Days</option>
	          <option value="M">Months</option>
	          <option value="Y">Years</option>';
		$t->set_var("type",$type);
	}
	if ($q->f("trial")==1)
	{
		$chck_funtions .= "display_tr(document.getElementById('trial_".$q->f("id")."'));";
		$t->set_var("trial", "Yes");
		$t->set_var("trial_chck", "checked");
			
		if ($q->f("trial_period_type")=="D") $days="selected";
		if ($q->f("trial_period_type")=="M") $months="selected";
		if ($q->f("trial_period_type")=="Y") $years="selected";
		$t->set_var("trial_period",$q->f("trial_period"));
		$trial_period_type = '<option value="D" '.$days.'>Days</option>
	          <option value="M" '.$months.'>Months</option>
	          <option value="Y" '.$years.'>Years</option>';
		$t->set_var("trial_period_type",$trial_period_type);
		$t->set_var("trial_amount", $q->f("trial_amount"));
	}
	else
	{
		$t->set_var("trial_chck", "");
		$t->set_var("trial", "No");
		$t->set_var("trial_amount", "");
		$t->set_var("trial_period", "");
		$trial_period_type = '<option value="D">Days</option>
	          <option value="M">Months</option>
	          <option value="Y">Years</option>';
		$t->set_var("trial_period_type",$trial_period_type);
	}
	if ($q->f("signup")==1)
	{
		$t->set_var("checked", "checked");
	}
	else
	{
		$t->set_var("checked", "");
	}
	$query="select id, name from membership";
	$q2->query($query);
	while ($q2->next_record())
	{
		if ($q->f("membership_id")==$q2->f("id")) $t->set_var("membership_selected", "selected");
		else $t->set_var("membership_selected", "");
		$t->set_var("membership_id", $q2->f("id"));
		$t->set_var("membership_name", $q2->f("name"));
		$t->parse("membership_lista", "membershiplista", true);
	}
	$comlev=0;
	$query="select * from levels where product_id='".$q->f("id")."' order by id";
	$q2->query($query);
	while ($q2->next_record())
	{
		if ($q2->f("paytype")=="percent_split" || $q2->f("paytype")=="full_amount_split")
		{
			$comlev+=1;
			$q2->next_record();
		}
		else $comlev+=1;
	}
	$query="select distinct membership_id from levels where product_id='".$q->f("id")."'";
	$q2->query($query);
	$t->set_var("comlevels", $comlev);
	$t->set_var("memno", $q2->nf());
	$t->parse("product_list", "productlist", true);
	$t->clear_var("membership_lista");
}
if ($q->nf()==0) $t->set_var("product_list", "");
$query="select id, name from membership";
$q->query($query);
while ($q->next_record())
{
	$t->set_var("membership_id", $q->f("id"));
	$t->set_var("membership_name", $q->f("name"));
	$t->parse("membership_list", "membershiplist", true);
}
$t->set_var('chck_funtions',$chck_funtions);
$t->set_var('physical_functions',$physical_functions);
$t->set_var('site_full_url',(strrpos(get_setting('site_full_url'),'/') == strlen(get_setting('site_full_url'))-1 ? get_setting('site_full_url') : get_setting('site_full_url').'/'));
include ("inc.bottom.php");
?>