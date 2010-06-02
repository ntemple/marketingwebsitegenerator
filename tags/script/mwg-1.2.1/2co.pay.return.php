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

 
include("inc.all.php");
$q2 = new CDb();
$q3 = new CDb();
$product_id = '';
$q->query("SELECT product_id,member_id FROM session WHERE session_id='$custom'");
$q->next_record();
$product_id = $q->f('product_id');
$member_id = $q->f('member_id');
$key = strtoupper(md5(get_setting("secret_key_2co").get_setting('sid').(get_setting('2co_demo') ? '1' : $_REQUEST['order_number']).$_REQUEST['total']));
if ($product_id){
	if ($key == $_REQUEST['key']){
		//CYCLE INSERT
		$cycle = base64_decode($_COOKIE['cycle']);
		$cycle_arr = explode(":",$cycle);
		$cycle_arr_first = explode("-",$cycle_arr[0]);
		$q2->query("SELECT file FROM cycle WHERE id='".$cycle_arr[count($cycle_arr)-1]."'");
		$q2->next_record();
		
		$q2->query("UPDATE cycle_stats SET used=1 WHERE id='".$cycle_arr_first[0]."'");
		//END CYCLER
		$query="select signup,display_name, price,nid from products where id='".$product_id."'";
		$q2->query($query);
	
		$q2->next_record();
		$product_nid=$q2->f("nid");
		$atsignup=$q2->f("signup");
		$price=$q2->f("price");
		$product_display_name=$q2->f("display_name");
		$comment = "New Payment: product name: ".$product_display_name.", product price: $".$price.", member: $member_id, Affiliate ID: $aff";
		$q3->query("INSERT INTO payment_log SET stamp='".time()."', ip='".getenv('REMOTE_ADDR')."', product='".$product_display_name."', txn_id='".$_REQUEST['order_number']."', comment='$comment', process_type='2Checkout'");
		if (get_setting("free_signup")!=1 && $atsignup!=0)
	
			{
				
				
				$q->query("UPDATE session SET paid=1 WHERE session_id='$custom' ORDER BY id ASC LIMIT 1");
				$q->query("SELECT * FROM session WHERE paid=1 AND session_id='$custom'");
				$q->next_record();
				$s_product_id=$q->f("product_id");
				$s_member_id=$q->f("member_id");
				$s_session=$q->f("session_id");
				$s_paid=$q->f("paid");
				$s_ip=$q->f("ip");
				
				$refund=1;
				$aff_id=$q->f("affiliate_id");
				
				if ($s_member_id==0)
				{
					$refund=0;
					if ($q->f("affiliate_id")!=0)
					{
						$aff_flag=1;
						$temp_id=$q->f("affiliate_id");
						$q2->query("SELECT email, membership_id FROM members WHERE id=$aff_id");
						$q2->next_record();
						$aff_email = $q2->f('email');
						$aff_membership_id = $q2->f('membership_id');
					}
					else $aff_flag=0;
				}
				else 
				{
					$aff_flag=0;
					$temp_id=$s_member_id;
				}
				process_sale($price, $temp_id ,$s_product_id, $aff_flag,$s_product_id,$member_id,$custom);
				if (get_setting("sales_email")==1)
				{
					$emailsubject=get_setting("sales_email_subject");
					$emailbody=get_setting("sales_email_body");
					$query="select * from members where id='$aff_id'";
					$q2->query($query);
					$q2->next_record();
					$query="select * from tags";
					$q3->query($query);
					while ($q3->next_record())
					{
						$emailsubject=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailsubject);
						$emailbody=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailbody);
						
					}
					
					$emailbody=str_replace("{product}", $product_display_name, $emailbody);
					
					$query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";
					
					$q->query($query);
					$q->next_record();
					$paytype = $q->f('paytype');
					if ($jv == 1){
						$jv_amount = $q->f("jv1");
					}elseif ($jv == 2){
						$jv_amount = $q->f("jv2");
					}else {
						if ($q->f("highcom")==1)
						{ 
							
							$b=time();
							$c=($aff_s_date+$q->f("highdays")*88400);
							if ($c > $b)
							{
								
								$jv_amount=$q->f("highval");
							}
							else 
							{
							
								$jv_amount = $q->f("value");
							} 
						}
						else 
						{	
						
							$jv_amount = $q->f("value");
						}
					}
					if ($paytype=="percent") $commsval=$jv_amount*$price/100;
					
					if ($paytype=="full_amount") $commsval=$jv_amount;
					
					$emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
					$emailbody=str_replace("{value}", $commsval, $emailbody);
					
					if($jv_amount != 0)
						mwg_mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
					
				}
				if (get_setting("enable_oto_paid_signup") == 1 && get_setting("enable_oto_1")){
	
						die ("<a href='".get_setting('site_full_url')."oto.php'>Continue to the site</a>");
					
				}else{
	
					die ("<a href='".get_setting('site_full_url')."pay.return.php?s=".$custom."'>Continue to the site</a>");
				}
		}elseif (get_setting("enable_oto_paid_signup") == 1 && get_setting("free_signup")!=1){
			$q->query("INSERT INTO session SET session_id='".session_id()."', product_id='".$product_id."', affiliate_id='".$_COOKIE['aff']."', paid=1,secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."'");
				if ($product_nid == "OTO2" || $product_nid == "OTO2_BCK") $extra ="?no=2";
					else $extra = "";
			
				header('Location: continue.php'.$extra);
				exit;
		}elseif (get_setting("free_signup")!=1){
			$q->query("SELECT membership_id FROM products WHERE id='".$product_id."'");
			$q->next_record();
			$q2->query("UPDATE session SET paid=1 WHERE session_id='$custom' ORDER BY id ASC LIMIT 1");
			$q2->query("UPDATE members SET membership_id='".$q->f('membership_id')."' WHERE id='".$member_id."'");
			updateHistory($member_id, $q->f('membership_id'), true);
				header('Location: continue.php');
				exit;
		}else {
			$query="select * from session where  session_id='$custom'";
			$q->query($query);
			$q->next_record();
			$s_product_id=$q->f("product_id");
			$s_member_id=$q->f("member_id");
			$s_session=$q->f("session_id");
			$s_paid=$q->f("paid");
			$s_ip=$q->f("ip");
			$refund=1;
			$aff_id=$q->f("affiliate_id");
			if ($s_member_id==0)
			{
				$refund=0;
				if ($q->f("affiliate_id")!=0)
				{
					$aff_flag=1;
					$temp_id=$q->f("affiliate_id");
				}
				else $aff_flag=0; 
			}
			else 
			{
				$aff_flag=0;
				$temp_id=$s_member_id;
			}			
			$q->query("SELECT membership_id, nid FROM products WHERE id='".$product_id."'");
			$q->next_record();
			$q2->query("UPDATE session SET paid=1 WHERE session_id='$custom' ORDER BY id ASC LIMIT 1");
			$q2->query("UPDATE members SET membership_id='".$q->f('membership_id')."' WHERE id='".$member_id."'");
			updateHistory($member_id, $q->f('membership_id'), true);
			if ($aff_id!=0)
					{
									
						$q2->query("SELECT email, membership_id FROM members WHERE id=$aff_id");
						$q2->next_record();
						$aff_email = $q2->f('email');
						$aff_membership_id = $q2->f('membership_id');
					}
			process_sale($price, $temp_id ,$s_product_id, $aff_flag, $s_product_id,$member_id,$custom);		
			if (get_setting("sales_email")==1)
				{
					
					$emailsubject=get_setting("sales_email_subject");
					$emailbody=get_setting("sales_email_body");
					$query="select * from members where id='$aff_id'";
					$q2->query($query);
					$q2->next_record();
					$query="select * from tags";
					$q3->query($query);
					while ($q3->next_record())
					{
						$emailsubject=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailsubject);
						$emailbody=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailbody);
						
					}
					
					$emailbody=str_replace("{product}", $product_display_name, $emailbody);
					
					$query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";
					$q->query($query);
					$q->next_record();
					$paytype = $q->f('paytype');
					if ($jv == 1){
						$jv_amount = $q->f("jv1");
					}elseif ($jv == 2){
						$jv_amount = $q->f("jv2");
					}else {
						if ($q->f("highcom")==1)
						{ 
							
							$b=time();
							$c=($aff_s_date+$q->f("highdays")*88400);
							if ($c > $b)
							{
								
								$jv_amount=$q->f("highval");
							}
							else {
								$jv_amount = $q->f("value");
							} 
						}
						else {	
							$jv_amount = $q->f("value");
						}
					}
					
					
					if ($paytype=="percent") $commsval=$jv_amount*$price/100;
					
					if ($paytype=="full_amount") $commsval=$jv_amount;
					
					$emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
					$emailbody=str_replace("{value}", $commsval, $emailbody);
					
					if($jv_amount != 0){
						
						mwg_mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
					}
				}
//sales email end
				header('Location: continue.php');
				exit;
		}
	}
}
?>