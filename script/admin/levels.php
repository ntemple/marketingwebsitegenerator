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
	$q3=new Cdb;
	$q4=new Cdb;
	$t->set_file("content", "admin.levels.html");
	$t->set_file("productlist", "admin.levels.product.select.html");
	$t->set_file("membershiplist", "admin.levels.membership.checkboxes.html");
	$t->set_file("levelslist", "admin.tiers.product.html");
	$t->set_file("tierlist", "admin.tiers.tier.html");
	$t->set_file("firstpayment", "admin.tiers.firstpayment.html");
	$t->set_file("secondpayment", "admin.tiers.secondpayment.html");
	$t->set_file("masspayment", "admin.tiers.masspay.html");
	$t->set_file("membership", "admin.tiers.membership.html");
	FFileRead("../templates/admin.levels.item.split.html", $levels_split);
	$t->set_var("currency", get_setting('paypal_currency'));
	$query="select * from levels group by product_id";
	$q->query($query);
	$next=0;$product='';$tierl='';$membershipid='';
	while ($q->next_record())
	{
		$membershipid='';
		$k=0;
		$query="select * from levels where product_id='".$q->f("product_id")."' group by membership_id";
		$q2->query($query);
		while ($q2->next_record())
		{	
			$t->unset_var("payment_structure");
			$p=0;
			$query1="select * from levels where product_id='".$q->f("product_id")."' and membership_id='".$q2->f("membership_id")."' order by level, id";
			
			$q3->query($query1);
			while ($q3->next_record())
			{
				$query="select price, display_name from products where id='".$q2->f("product_id")."'";
				$q4->query($query);
				while($q4->next_record())
				{
					$t->set_var("product_name", $q4->f("display_name"));
					$t->set_var("price", $q4->f("price"));
					$t->set_var("currency", get_setting('paypal_currency'));
				}
				
				$query="select name from membership where id='".$q3->f("membership_id")."'";
				$q4->query($query);
				$q4->next_record();
				$t->set_var("membership_name", $q4->f("name"));
		
				
		
				if ($q3->f("paytype")=="percent_split" or $q3->f("paytype")=="full_amount_split")
				{
					$next=1;
				}
				if ($next==1)
				{
					$t->set_var("paytype", "Instant to PayPal");
					$t->set_var("currency", get_setting('paypal_currency'));
					if (get_setting("splitoption")==2) 
					{
						$t->set_var("befaf", "after");
						$t->set_var("befaf2", "before");
					}
					else
					{
						$t->set_var("befaf", "before");
						$t->set_var("befaf2", "after");
					}
					$t->set_var("value", $q3->f("value"));
					$t->set_var("jv1", $q3->f("jv1"));
					$t->set_var("jv2", $q3->f("jv2"));
					$t->set_var("tier", $q3->f("level"));
					$t->set_var("level_id", $q3->f("id"));
					if ($q3->f("highcom")==1)
					{
						if ($q3->f("paytype")=="percent" || $q3->f("paytype")=="percent_split")
						{
							$t->set_var("special", "This payment is set to give promoter a ".$q3->f("highval")."% commission for the first ".$q3->f("highdays")." after he signed up and started promoting(after ".$q3->f("highdays")." days the commision will return to the normal values)");
							$t->set_var("st", "");
							$t->set_var("st1", "%");
						}
						if ($q3->f("paytype")=="full_amount" || $q3->f("paytype")=="full_amount_split")
						{
							$t->set_var("special", "This payment is set to give promoter a {st}".$q3->f("highval")."{st1} commission for the first ".$q3->f("highdays")." after he signed up and started promoting(after ".$q3->f("highdays")." days the commision will return to the normal values)");
							$t->set_var("st", "");
							$t->set_var("st1", get_setting('paypal_currency'));
						}
		
					}
					else $t->set_var("special", "No special commissions defined");
					if ($q3->f("paytype")=="percent" || $q3->f("paytype")=="percent_split")
					{
						
						$t->set_var("st", "");
						$t->set_var("st1", "%");
					}
					if ($q3->f("paytype")=="full_amount" || $q3->f("paytype")=="full_amount_split")
					{
						
						$t->set_var("st", "");
						$t->set_var("st1", get_setting('paypal_currency'));
					}
					
					$t->parse("payment_structure",  "firstpayment"); //no
					$t->unset_var("level_id");
					$q3->next_record();	
					
					if ($q3->f("paytype")=="percent" || $q3->f("paytype")=="percent_split")
					{
						
						$t->set_var("st", "");
						$t->set_var("st1", "%");
					}
					if ($q3->f("paytype")=="full_amount" || $q3->f("paytype")=="full_amount_split")
					{	
						$t->set_var("st", "");
						$t->set_var("st1", get_setting('paypal_currency'));
					}
					
					if ($q3->f("highcom")==1)
					{
						$t->set_var("special", "This payment is set to give the admin a {st}".$q3->f("highval")."{st1} commission for the first ".$q3->f("highdays")." after he signed up and started promoting(after ".$q3->f("highdays")." days the commision will return to the normal values)");
					
					}
					else $t->set_var("special", "No special commisions defined");
					
					$t->set_var("value", $q3->f("value"));
					$t->set_var("jv1", $q3->f("jv1"));
					$t->set_var("jv2", $q3->f("jv2"));
					$t->parse("payment_structure",  "secondpayment", true); 
				
					if ($q3->nf()>2 && $tierl!=$q3->f("level") && $p>0) $t->parse("payment_tiers", "tierlist", true);
					else {$t->parse("payment_tiers", "tierlist"); }$p++; 
					$tierl=$q3->f("level");
				
					$next=0;
				}
				else
				{
					$t->set_var("paytype", "Mass Payment");
					$t->set_var("value", $q3->f("value"));
					$t->set_var("jv1", $q3->f("jv1"));
					$t->set_var("jv2", $q3->f("jv2"));
					$t->set_var("tier", $q3->f("level"));
					$t->set_var("level_id", $q3->f("id"));
				
					if ($q3->f("paytype")=="percent" || $q3->f("paytype")=="percent_split")
					{
						if ($q3->f("highcom")==1)
						{
							$t->set_var("special", "This payment is set to give promoter a ".$q3->f("highval")."% commission for the first ".$q3->f("highdays")." after he signed up and started promoting(after ".$q3->f("highdays")." days the commision will return to the normal values)");
							
						}
						else $t->set_var("special", "No special commissions defined");
						$t->set_var("st", "");
						$t->set_var("st1", "%");
								
					}
					else
					if ($q3->f("paytype")=="full_amount" || $q3->f("paytype")=="full_amount_split")
					{
						if ($q3->f("highcom")==1)
						{
							$t->set_var("special", "This payment is set to give promoter a $".$q3->f("highval")." commission for the first ".$q3->f("highdays")." after he signed up and started promoting(after ".$q3->f("highdays")." days the commision will return to the normal values)");
						}
						else $t->set_var("special", "No special commissions defined");
						$t->set_var("st", "");
						$t->set_var("st1", get_setting('paypal_currency'));
					}
					else $t->set_var("special", "No special commissions defined");
					
					$t->parse("payment_structure",  "masspayment"); 
					if ($membershipid!=$q2->f("membership_id")) $t->parse("payment_tiers", "tierlist", true);
					else $t->parse("payment_tiers", "tierlist");
					
				}
				
				
			} 
			if ($q2->nf()>2 && $membershipid!=$q2->f("membership_id") && $k>0) $t->parse("product_memberships", "membership", true);
			else 
			{
				if ($membershipid==$q2->f("membership_id")) {
					$t->parse("product_memberships", "membership"); 
				}
				else $t->parse("product_memberships", "membership", true); 
				
			}
			$k++;
			$membershipid=$q2->f("membership_id");
			$t->parse("payment_structure",  "masspayment");
			$t->unset_var("payment_tiers");	
		} 
		
		$t->parse("levels_list", "levelslist", true);
		$t->unset_var("product_memberships"); 
		$t->unset_var("payment_structure");
		$t->unset_var("payment_tiers");
		
	} 
	if ($q->num_rows()==0) $t->set_var("levels_list", "No tiers defined");
	
	$query="select id, display_name, price from products";
	$q->query($query);
	while($q->next_record())
	{
		$t->set_var("product_id", $q->f("id"));
		$t->set_var("product_name", $q->f("display_name")." (".$q->f("price")." ".get_setting('paypal_currency').")");
		$t->parse("product_list", "productlist", true);
	}
	
	$query="select id, name from membership where active=1";
	$q->query($query);
	while($q->next_record())
	{
		$t->set_var("membership_id", $q->f("id"));
		$t->set_var("membership_name", $q->f("name"));
		$t->parse("membership_list", "membershiplist", true);
	}
	$t->set_var("error", $error);
	include ("inc.bottom.php");
?>