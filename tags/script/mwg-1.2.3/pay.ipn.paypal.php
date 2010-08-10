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


  require_once("inc.all.php");
  $q2=new CDB;
  $q3=new CDB;
  $q4=new CDB;
  $item_name                      = $_POST['item_name'];
  $item_number                    = $_POST['item_number'];
  $payment_status                 = $_POST['payment_status'];
  $payment_amount                 = $_POST['mc_gross'];
  $payment_currency               = $_POST['mc_currency'];
  $txn_id                         = $_POST['txn_id'];
  $receiver_email                 = $_POST['receiver_email'];
  $payer_email                    = $_POST['payer_email'];
  $txn_type                       = $_POST['txn_type'];
  $custom                         = $_POST['custom'];
  $pmt_type	    	         	      = $_POST['payment_type'];
  $pndg_reason	            	    = $_POST['pending_reason'];
  $mc_amount1		            	    = $_POST['mc_amount1'];
  $shipping                       = $_POST['shipping'];
  $tax                            = $_POST['tax'];
  
  // read the post from PayPal system and add 'cmd'
  $req = 'cmd=_notify-validate';
  foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
  }
  mysql_query("SHOW COLUMNS FROM paypal_log");
  if(mysql_error()==''){
    $q->query("INSERT INTO paypal_log set vars='".$req."',item_name='$item_name',item_number='$item_number',payment_status='$payment_status',mc_gross='$mc_gross',mc_currency='$payment_currency',txn_id='$txn_id',receiver_email='$receiver_email',payer_email='$payer_email',txn_type='$txn_type',custom='$custom',payment_type='$pmt_type',pending_reason='$pndg_reason',mc_amount1='$mc_amount1',shipping='$shipping',tax='$tax'");
  }
  // post back to PayPal system to validate
  $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
  $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
  $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
  if ((strpos($_SERVER['SERVER_SOFTWARE'], 'ssl') === false) && (strpos($_SERVER['SERVER_SOFTWARE'], 'SSL') === false))
  {
    $fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30); // no ssl found on the server
  }
  else
  {
    $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); // server does have ssl compiled
  }

  $valid = true; // NLT Assume valid until we can fix this spaghetti
  MWG::getInstance()->runEvent('paypalIPN', array($_POST, $valid));


  // assign posted variables to local variables
  $shipping_email_subject=get_setting("shipping_email_subject");
  $shipping_email_body=get_setting("shipping_email_body");
  $shipping_email=get_setting("shipping_email");
  $send_shipping_email=get_setting("send_shipping_email");
  $ship_ask_company=get_setting("shipping_email_from");
  $payment_amount=$payment_amount-$shipping-$tax;
  $payment_amount=number_format($payment_amount,2,".", "");
  $shipping_email_body=str_replace("{ship_quantity}", $item_name, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_product}", $quantity, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_first_name}", $first_name, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_last_name}", $last_name, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_address_street}", $address_street, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_address_city}", $address_city, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_address_zip}", $address_zip, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_address_country}", $address_country, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_address_country_code}", $address_country_code, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_to_address_state}", $address_state, $shipping_email_body);
  $shipping_email_body=str_replace("{ship_ask_company}", $ship_ask_company, $shipping_email_body);
  $from_paypal=explode("|", $custom);
  $custom=$from_paypal[0];
  $country_code=$from_paypal[1];
  $query="SELECT * FROM countries WHERE country_id='$country_code'";
  $q2->query($query);
  $q2->next_record();
  $country_member=$q2->f("country");
  $county_match=0;
  $query="select * from session where session_id='$custom'";
  $q->query($query);
  $q->next_record();
  $s_product_id=$q->f("product_id");
  $query="SELECT physical FROM products WHERE id='$s_product_id'";
  $q2->query($query);
  $q2->next_record();
  if ($q2->f("physical")==1) {
    $is_physical=1;
  } else {
    $is_physical=0;
  }
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
    $q2->query("SELECT nid FROM products WHERE id='$s_product_id'");
    $q2->next_record();
    if ($q2->f('nid') == 'OTO1'){
      $q2->query("UPDATE members SET seen='2' WHERE id='$s_member_id'");
    }elseif ($q2->f('nid') == 'OTO2'){
      $q2->query("UPDATE members SET seen='3' WHERE id='$s_member_id'");
    }
    $aff_flag=0;
    $temp_id=$s_member_id;
  }
  $q2->query("SELECT trial, trial_amount, price,display_name FROM products WHERE id='$s_product_id'");
  $q2->next_record();
  $product_display_name = $q2->f("display_name");
  if($payment_status=="Refunded"){
    $payment_amount=-$payment_amount;
  }
  if ($q2->f('trial')){
    $trial_amount = $q2->f('trial_amount');
  }elseif (md5(number_format($payment_amount,2))!=md5(number_format($q2->f('price'),2)) && ($txn_type!="subscr_eot" && $txn_type!="subscr_cancel")) {
    die("ERROR: Price not correct!");
  }
  $comment='';
  $allowecheck=0;
  $allowecheck1=0;
  if (!$fp) {
    // HTTP ERROR
  } else {
    fputs ($fp, $header . $req);
    while (!feof($fp)) {
      $res = fgets ($fp, 1024);
      if (strcmp ($res, "VERIFIED") == 0) {
        // check the payment_status is Completed 

        foreach ($_POST as $key => $value) {
          $value = urlencode(stripslashes($value));
          $req2 .= "&$key=$value";
        }
        if ($txn_id!=get_setting("txn_id") || (isset($mc_amount1) && $mc_amount1 == '0.00' && isset($trial_amount) && $trial_amount == '0.00') || ($txn_type=="subscr_eot" || $txn_type=="subscr_cancel"))
        {
          set_setting("txn_id", $txn_id);

          if ($txn_type=="subscr_cancel" || $txn_type=="subscr_eot")

          {
            if ($refund==1)
            {
              if (get_setting("delete_user")==1 && get_setting("cancel_new_system")!=1) $q->query("delete from members where id='$s_member_id'");
              if (get_setting("suspend_user")==1 && get_setting("cancel_new_system")!=1) {
                $q->query("update members set suspended='1' where id ='$s_member_id'");
              }

              if ( get_setting("cancel_new_system")==1) {
                $query="SELECT * FROM members WHERE id='$s_member_id'";
                $q->query($query);
                $q->next_record();
                $current_membership=$q->f("membership_id");
                $query="SELECT * FROM membership WHERE id='$current_membership'";
                $q->query($query);
                $q->next_record();
                $current_rank=$q->f("rank");
                $query="SELECT * FROM products WHERE id='$s_product_id'";
                $q->query($query);
                $q->next_record();
                $product_membership=$q->f("membership_id");
                $query="SELECT * FROM membership WHERE id='$product_membership'";
                $q->query($query);
                $q->next_record();
                $product_rank=$q->f("rank");	
                if ($current_rank>$product_rank) {
                  updateHistory($s_member_id, $product_membership,false);
                } elseif ($current_rank==$product_rank) {
                  $query="SELECT * FROM products where id='$s_product_id'";
                  $q->query($query);
                  $q->next_record();
                  $membership_h_id=$q->f("membership_id");
                  updateHistory($s_member_id, $membership_h_id,false);
                  $query="SELECT history FROM members WHERE id='$s_member_id'";
                  $q4->query($query);
                  $q4->next_record();
                  $history=$q4->f('history');
                  $history_exp=explode(",", $history);
                  // BUG?? Assumes that membership rank is ordered by id.  False if these have been reordered.
                  $max_rank=max($history_exp);
// selecting everything based on id ...
                  $query="SELECT * FROM membership WHERE id='$max_rank'";
                  $q4->query($query);
                  $q4->next_record();
                  $new_membership=$q4->f("id");
// then setting new_membership to id. Null action.
                  $query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
                  $q->query($query);		
                }
              }
              if(get_setting("change_membership")!="xref_none" && get_setting("change_membership")>0 && get_setting("change_membership")!='Chose membership') {

                $query="SELECT * FROM membership WHERE id='".get_setting("change_membership")."'";
                $q4->query($query);
                $q4->next_record();
                $new_membership=$q4->f("id");
                updateHistory($s_member_id, $new_membership,false);
                $query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
                $q->query($query);
              }
              $query="select * from a_tr where session='$custom'";
              $q->query($query);
              if ($q->nf()==0)
              {
                $comment.="no session found, need to delete a comm from a_tr";
                if ($s_member_id!=0)
                {
                  if ($aff_id!=0)
                  {
                    $query="select price from products where id='$s_product_id'";
                    $q2->query($query);
                    $q2->next_record();
                    $product_price=$q2->f("price");
                    $query="select membership_id, jv from members where id='$aff_id'";
                    $q2->query($query);
                    $q2->next_record();
                    $aff_membership_id=$q2->f("membership_id");
                    $aff_jv=$q2->f("jv");
                    $query="select * from levels where membership_id='$aff_membership_id' and product_id='$s_product_id' and level=1";
                    $q2->query($query);
                    $q2->next_record();
                    if ($q2->nf()==0)
                    {
                      $comment.=" no level defined. nothing to do";
                    }
                    else
                      if ($q2->nf()==1)
                      {
                        if ($aff_jv!=0)
                        {
                          if ($q2->f("jv".$aff_jv)==0)
                          {
                            if ($q2->f("paytype")=="percent")
                            {
                              $commsvalue=$product_price*$q2->f("value")/100;
                            }
                            else
                            {
                              $commsvalue=$q2->f("value");
                            }
                          }
                          else
                          {
                            if ($q2->f("paytype")=="percent")
                            {
                              $commsvalue=$product_price*$q2->f("jv".$aff_jv)/100;
                            }
                            else
                            {
                              $commsvalue=$q2->f("jv".$aff_jv);
                            }
                          }
                        }
                        else
                        { 
                          if ($q2->f("paytype")=="percent")
                          {
                            $commsvalue=$product_price*$q2->f("value")/100;
                          }
                          else
                          {
                            $commsvalue=$q2->f("value");
                          }
                        }
                      }
                      $query="update a_tr set  comments=CONCAT(comments, ' Cancelated.') where round(amount)=round(".number_format($commsvalue,4).") and member_id='$aff_id' and status!='3' limit 1";
                    $q2->query($query);
                  }
                }
              }
              else
              {
                $query="update a_tr set  comments=CONCAT(comments, ' Cancelled.') where session='$custom'";
                $q2->query($query);
              }
            }
            $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='Product id:".$s_product_id.",Subscription cancelled',buyer_id='$s_member_id',affiliate_id='$affiliate_id',session_id='$custom',status='Cancelled',process_type='paypal'");
            die();	
          }
          if ($payment_status=="Refunded")
          {
            if ($refund==1)
            {
              if (get_setting("delete_user")==1 && get_setting("cancel_new_system")!=1) $q->query("delete from members where id='$s_member_id'");
              if (get_setting("suspend_user")==1 && get_setting("cancel_new_system")!=1) {
                $q->query("update members set suspended='1' where id ='$s_member_id'");
              }
              if ( get_setting("cancel_new_system")==1) {
                $query="SELECT * FROM members WHERE id='$s_member_id'";
                $q->query($query);
                $q->next_record();
                $current_membership=$q->f("membership_id");
                $query="SELECT * FROM membership WHERE id='$current_membership'";
                $q->query($query);
                $q->next_record();
                $current_rank=$q->f("rank");
                $query="SELECT * FROM products WHERE id='$s_product_id'";
                $q->query($query);
                $q->next_record();
                $product_membership=$q->f("membership_id");
                $query="SELECT * FROM membership WHERE id='$product_membership'";
                $q->query($query);
                $q->next_record();
                $product_rank=$q->f("rank");
                if ($current_rank>$product_rank) {
                  updateHistory($s_member_id, $product_membership,false);
                } elseif ($current_rank==$product_rank) {
                  $query="SELECT * FROM products where id='$s_product_id'";
                  $q->query($query);
                  $q->next_record();
                  $membership_h_id=$q->f("membership_id");
                  updateHistory($s_member_id, $membership_h_id,false);
                  $query="SELECT history FROM members WHERE id='$s_member_id'";
                  $q4->query($query);
                  $q4->next_record();
                  $history=$q4->f('history');
                  $history_exp=explode(",", $history);
                  $max_rank=max($history_exp);
                  $query="SELECT * FROM membership WHERE id='$max_rank'";
                  $q4->query($query);
                  $q4->next_record();
                  $new_membership=$q4->f("id");
                  $query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
                  $q->query($query);
                }
              }
              if(get_setting("change_membership")!="xref_none" && get_setting("change_membership")>0 && get_setting("change_membership")!='Chose membership') {

                $query="SELECT * FROM membership WHERE id='".get_setting("change_membership")."'";
                $q4->query($query);
                $q4->next_record();
                $new_membership=$q4->f("id");
                updateHistory($s_member_id, $new_membership,false);
                $query="update members set membership_id='".$new_membership."' where id='$s_member_id'";

                $q->query($query);
              }
              $query="select * from a_tr where session='$custom'";
              $q->query($query);
              if ($q->nf()==0)
              {
                $comment.="no session found, need to delete a comm from a_tr";
                if ($s_member_id!=0)
                {
                  if ($aff_id!=0)
                  {
                    $query="select price from products where id='$s_product_id'";
                    $q2->query($query);
                    $q2->next_record();
                    $product_price=$q2->f("price");
                    $query="select membership_id, jv from members where id='$aff_id'";
                    $q2->query($query);
                    $q2->next_record();
                    $aff_membership_id=$q2->f("membership_id");
                    $aff_jv=$q2->f("jv");
                    $query="select * from levels where membership_id='$aff_membership_id' and product_id='$s_product_id' and level=1";
                    $q2->query($query);
                    $q2->next_record();
                    if ($q2->nf()==0)
                    {
                      $comment.=" no level defined. nothing to do";
                    }
                    else
                      if ($q2->nf()==1)
                      {
                        if ($aff_jv!=0)
                        {
                          if ($q2->f("jv".$aff_jv)==0)
                          {
                            if ($q2->f("paytype")=="percent")
                            {
                              $commsvalue=$product_price*$q2->f("value")/100;
                            }
                            else
                            {
                              $commsvalue=$q2->f("value");
                            }
                          }
                          else
                          {
                            if ($q2->f("paytype")=="percent")
                            {
                              $commsvalue=$product_price*$q2->f("jv".$aff_jv)/100;
                            }
                            else
                            {
                              $commsvalue=$q2->f("jv".$aff_jv);
                            }
                          }
                        }
                        else
                        { 
                          if ($q2->f("paytype")=="percent")
                          {
                            $commsvalue=$product_price*$q2->f("value")/100;
                          }
                          else
                          {
                            $commsvalue=$q2->f("value");
                          }
                        }
                      }
                      $query="update a_tr set status='3', comments=CONCAT(comments, ' Refunded.') where round(amount)=round(".number_format($commsvalue,4).") and member_id='$aff_id' and status!='3' limit 1";
                    $q2->query($query);
                  }
                }
              }
              else
              {
                $query="update a_tr set status=3, comments=CONCAT(comments, ' Refunded.') where session='$custom'";
                $q2->query($query);
              }
            }
            $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='Product id:".$s_product_id.",Refund was made',buyer_id='$s_member_id',affiliate_id='$affiliate_id',session_id='$custom',status='Refunded',process_type='paypal'");
            die();	
          }
          if ($payment_status=="Pending")
          {
            $comment= "Pending Transaction";
            if ($pndg_reason=="echeck")
            {
              $comment.=" reason: echeck";
              if (get_setting("accept_echeck")==1)
              {
                if ($get_setting("echeck")==1)
                {
                  $comment.="The option to treat the member as if the payment was completed successfully was selected, we are gonna upgrade the member and give him access to the downloads. ";
                  $allowecheck=1;
                }
                else 
                {
                  $comment.="Member will be upgraded to his membership but won't be granted access to the downloads until the echeck clears";
                }
              }
              else
              {
                $comment.= " we are not accepting transactions via echeck so this was not processed";
              }
            }
            else
            {
              $comment.= " The reason for the pending transaction was: ".$pndg_reason;
            }
          }
          if ($payment_status=="Completed" || ($payment_status=="Pending" && $pmt_type=="echeck" && get_setting("accept_echeck")==1) || (isset($mc_amount1) && $mc_amount1 == '0.00' && isset($trial_amount) && $trial_amount == '0.00'))
          {
            if ($country_code==$address_country_code) {
              $county_match=1;
            } else {
              $county_match=0;
              $country_error="Member chosse to ship the product in ".$country_member.", but from Paypal we got as country of residence ".$address_country."!

              Content of the email that should be sent to your shipping company is:
              ";						
            }

            if ($is_physical==1 && get_setting("send_shipping_email")==1 && $county_match==1) {
              mwg_mail($shipping_email, $shipping_email_subject, $shipping_email_body, "From: ".$ship_ask_company);
            } elseif ($is_physical==1 && get_setting("send_shipping_email")==1 && $county_match==0) {
              $shipping_email_subject.=" (country error)";
              $shipping_email_body=$country_error.$shipping_email_body;
              mwg_mail($shipping_email, $shipping_email_subject, $shipping_email_body, "From: ".$ship_ask_company);
            }
            if ($is_physical==1 && get_setting("sendtohost_disk")==1 && $county_match==1) {
              if ($address_country_code=="US") {
                $shipping_method="FedEx Ground";
              } else {
                $shipping_method="USPS Global Priority Mail";
              }
              $http_link_disk="os=".urlencode($payer_business_name)."|".urlencode($business)."|".urlencode("Test%20Customer")."|".urlencode($address_street)."||".urlencode($address_city)."|".urlencode($address_state)."|".urlencode($address_zip)."|".urlencode($address_country)."|||".urlencode($shipping_method)."||||".urlencode($payer_email)."|||"."&items=".urlencode($item_name).":".urlencode($quantity)."&companyid=&shipacct=&returnurl=";
              sendToHost("www.customers.disk.com","POST","/remotepackageship.jsp",$http_link_disk,$useragent=0);
            } elseif ($is_physical==1 && get_setting("sendtohost_disk")==1 && $county_match=="0") {
              $shipping_email_subject.=" (country error)";
              $shipping_email_body=$country_error.$shipping_email_body;
              mwg_mail($shipping_email, $shipping_email_subject, $shipping_email_body, "From: ".$ship_ask_company);
            }
            process_sale($payment_amount, $temp_id ,$s_product_id, $aff_flag, $s_product_id, $s_member_id, $s_session);
            $comment .= "New payment: ";
            if ($s_paid==1) 
            {
              $paid2=1;
              $paid=1;
              $comment .= "Second Payment: ";
            }
            else
            {
              $paid=1;
              $paid2=0;
              $comment .= "First Payment: ";

            }

            $query="select * from products where id='$s_product_id'";
            $q->query($query);
            $q->next_record();
            $trial_amount = $q->f("trial_amount");
            $price = $q->f("price");
            $membership_id=$q->f("membership_id");
            $product_display_name = $q->f("display_name");
            $comment .= "product name: ".$q->f("display_name").", product price: $".$q->f("price");
            $q->query("SELECT name, rank FROM membership WHERE id='".$membership_id."'");
            $q->next_record();
            $membership_name_ipn = $q->f("name");
            $product_rank_new=$q->f("rank");
            if ($s_member_id!=0) {
              $query="SELECT membership_id FROM members WHERE id='$s_member_id'";
              $q->query($query);
              $q->next_record();
              if ($q->nf()>0) {
                $membership_id_member=$q->f('membership_id');
                $q->query("SELECT rank FROM membership WHERE id='".$q->f('membership_id')."'");
                $q->next_record();
                $member_rank_new=$q->f("rank");
              }
            } else {
              $member_rank_new=0;
            }
            if ($member_rank_new<=$product_rank_new) {
              $membership_id_new=$membership_id;
            } else {
              $membership_id_new=$membership_id_member;
            }
            if ($aff_id)
            {
              $comment .= ", affiliate id: ".$aff_id.". ";
              $q->query("SELECT s_date, email, membership_id, paypal_email, jv FROM members WHERE id='$aff_id'");
              $q->next_record();
              $aff_membership_id = $q->f("membership_id");
              $aff_pp=$q->f("paypal_email");
              $aff_email=$q->f("email");
              $aff_s_date=$q->f("s_date");
              $jv = $q->f("jv");

              $q->query("SELECT * FROM levels WHERE membership_id='$aff_membership_id' AND product_id='$s_product_id' and level=1 order by id desc limit 0,1");
              $nums=$q->nf();
              if ($q->nf() == 0 || $q->nf() == 1)
              {
                $q->next_record();
                $paytype=$q->f("paytype");
                $value=$q->f("value");
                $price=number_format($price,2,".", "");
                if($price == $payment_amount || $payment_amount == $trial_amount){
                  $comment .= "No level, or non split level found, only one payment required, payment amount: ".$price.". member: ".$s_member_id." upgraded to ".$membership_name_ipn;
                  if ( $pmt_type=="echeck")
                  {
                    if ($allowecheck==1) {										
                      $query="update members set membership_id='$membership_id_new', echeck='1' where id='$s_member_id'"; 

                    }else {
                      $query="update members set membership_id='$membership_id_new', echeck='2' where id='$s_member_id'"; 

                    }
                  }
                  else
                  {
                    $query="update members set membership_id='$membership_id_new' where id='$s_member_id'"; 
                  }
                  $q->query($query);

                  updateHistory($s_member_id, $membership_id, true);

                  if (get_setting("sales_email")==1 && $nums==1)
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

                    if (get_setting("splitoption")==2){

                      $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id desc limit 0,1";
                    }else {
                      $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";

                    }

                    $q->query($query);
                    $q->next_record();

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
                    if($payment_amount==0) $jv_amount=0;

                    if ($price==$payment_amount) {
                      if ($paytype=="percent") $commsval=$jv_amount*$price/100;
                      if ($paytype=="full_amount") $commsval=$jv_amount;
                    } elseif ($trial_amount==$payment_amount) {
                      if ($paytype=="percent") $commsval=$jv_amount*$trial_amount/100;
                      if ($paytype=="full_amount") $commsval=$jv_amount;
                    }
                    $emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
                    $emailbody=str_replace("{value}", $commsval, $emailbody);
                    if($s_member_id!=''){
                      $query = "select * from members where id='$s_member_id'";
                      $q2->query($query);
                      $q2->next_record();
                      $emailbody = str_replace("{buyer_first_name}", $q2->f("first_name"), $emailbody);
                      $emailbody = str_replace("{buyer_last_name}", $q2->f("last_name"), $emailbody);
                      $emailbody = str_replace("{buyer_id}", $q2->f("id"), $emailbody);
                      $emailbody = str_replace("{buyer_email}", $q2->f("email"), $emailbody);
                      $member_details = "Id: ".$q2->f("id")."\nName: ".$q2->f("first_name")." ".$q2->f("last_name")."\nEmail: ".$q2->f("email");
                      $emailbody = str_replace("{member_details}", $member_details, $emailbody);
                    }else{
                      $emailbody = str_replace("{buyer_first_name}", "", $emailbody);
                      $emailbody = str_replace("{buyer_last_name}", "", $emailbody);
                      $emailbody = str_replace("{buyer_id}", "", $emailbody);
                      $emailbody = str_replace("{buyer_email}", "", $emailbody);
                      $emailbody = str_replace("{member_details}", "", $emailbody);
                    }
                    if($jv_amount != 0)
                      mwg_mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
                  }
                }else{
                  $comment .= "No level, or non split level found, only one payment required, but the payment amount, ".$payment_amount.", did not match database value, ".$price.". Member not upgraded.";
                  $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."',session_id='$custom'");
                  die("Fraud attempt payment no level or one");
                }
              }
              else
              {

                if (get_setting("sales_email")==1 && $paid == 1 && $paid2 == 0 && $aff_pp!='')
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
                  $commsval=$price;
                  $emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
                  $emailbody=str_replace("{value}", $commsval, $emailbody);
                  $query = "select * from members where id='$s_member_id'";
                  $q2->query($query);
                  $q2->next_record();
                  if($s_member_id!=''){
                    $query = "select * from members where id='$s_member_id'";
                    $q2->query($query);
                    $q2->next_record();
                    $emailbody = str_replace("{buyer_first_name}", $q2->f("first_name"), $emailbody);
                    $emailbody = str_replace("{buyer_last_name}", $q2->f("last_name"), $emailbody);
                    $emailbody = str_replace("{buyer_id}", $q2->f("id"), $emailbody);
                    $emailbody = str_replace("{buyer_email}", $q2->f("email"), $emailbody);
                    $member_details = "Id: ".$q2->f("id")."\nName: ".$q2->f("first_name")." ".$q2->f("last_name")."\nEmail: ".$q2->f("email");
                    $emailbody = str_replace("{member_details}", $member_details, $emailbody);
                  }else{
                    $emailbody = str_replace("{buyer_first_name}", "", $emailbody);
                    $emailbody = str_replace("{buyer_last_name}", "", $emailbody);
                    $emailbody = str_replace("{buyer_id}", "", $emailbody);
                    $emailbody = str_replace("{buyer_email}", "", $emailbody);
                    $emailbody = str_replace("{member_details}", "", $emailbody);
                  }
                  mwg_mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
                }
                if ($paid == 1 && $paid2 == 0){
                  if ($aff_pp=='' || ($aff_pp!='' && get_setting("splitoption")==2)){
                    if($price == $payment_amount || $payment_amount == $trial_amount){
                      $comment .= " Affiliate had no paypal email, only one payment required amount: $".$price.", member: ".$s_member_id." upgraded to ".$membership_name_ipn;
                      if ( $pmt_type=="echeck")
                      {
                        if ($allowecheck==1)	{										
                          $query="update members set membership_id='$membership_id_new', echeck='1' where id='$s_member_id'";

                        }else {
                          $query="update members set membership_id='$membership_id_new', echeck='2' where id='$s_member_id'"; 

                        }
                      }
                      else
                      {
                        $query="update members set membership_id='$membership_id_new' where id='$s_member_id'"; 
                      }

                      $q->query($query);

                      updateHistory($s_member_id, $membership_id, true);

                    }else{
                      $comment .= " Affiliate had no paypal email. Payment amount was: $".$payment_amount.", it should have been: $".$price.". Member not upgraded";
                      $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."',session_id='$custom'");
                      die("Fraud attempt payment 1 no aff email");
                    }
                  }else{
                    $comment .= "Split found, payment 1";
                    if (get_setting("splitoption")==2){

                      $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id desc limit 0,1";
                    }else {
                      $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";

                    }

                    $q->query($query);
                    $q->next_record();

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

                    if ($q->f("paytype") == "percent_split"){
                      $comment .= ". Affiliate is ".($jv == 0 ? "not jv. using default payment value: ".$jv_amount."%" : "jv: ".$jv." using jv payment value: ".$jv_amount."%");
                      if ($payment_amount == number_format(($price * $jv_amount/100),2,".", "") || $payment_amount == $trial_amount){
                        $comment .= ". Split is percent, payment amount is: $".$payment_amount.". payment ok, waiting for second payment, from member: $s_member_id";
                      }else{
                        $comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".($price * $jv_amount/100).". Payment not ok";
                        $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."',session_id='$custom'");
                        die("Fraud attempt first payment percent split ");
                      }
                    }else{
                      $comment .= ". Affiliate is ".($jv == 0 ? "not jv. using default payment value: $".$jv_amount : "jv: ".$jv." using jv payment value: $".$jv_amount);
                      if ($payment_amount == $jv_amount || $payment_amount == $trial_amount){
                        $comment .= ". Split is full amount, amount is: $".$payment_amount.". payment ok, waiting for second payment, from member: $s_member_id";
                      }else{

                        $comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".$jv_amount.". Payment not ok.";
                        $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."',session_id='$custom'");
                        die("Fraud attempt first payment full split");
                      }
                    }
                  }
                  if (get_setting("splitoption")==2)
                  {
                    $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";
                  }
                  else 
                  {
                    $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id desc limit 0,1";
                  }
                  $q->query($query);
                  $q->next_record();

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
                  if ($jv_amount==0)
                  {
                    if ( $pmt_type=="echeck")
                    {
                      if ($allowecheck==1){											
                        $query="update members set membership_id='$membership_id_new', echeck='1' where id='$s_member_id'"; 

                      }else {
                        $query="update members set membership_id='$membership_id_new', echeck='2' where id='$s_member_id'"; 
                      }
                    }
                    else
                    {
                      $query="update members set membership_id='$membership_id_new' where id='$s_member_id'"; 
                    }
                    $q->query($query);

                    updateHistory($s_member_id, $membership_id, true);

                    $comment.="Second payment is 0, member upgraded";
                    $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment',session_id='$custom'");
                  }
                }
                if ($paid2 == 1 && $paid == 1)
                {
                  $comment .= "Split found, payment 2.";

                  if (get_setting("splitoption")==2){

                    $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id asc limit 0,1";
                  }else {
                    $query="select * from levels where product_id='$s_product_id' and membership_id='$aff_membership_id' and level=1 order by id desc limit 0,1";			
                  }
                  $q->query($query);
                  $q->next_record();
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
                  if ($q->f("paytype") == "percent_split"){
                    $comment .= "affiliate is ".($jv == 0 ? "not jv. using default payment value: ".$jv_amount."%" : "jv: ".$jv." using jv payment value: ".$jv_amount."%");

                    if ($payment_amount == number_format(($price * $jv_amount/100),2,".", "") || $payment_amount == $trial_amount){
                      $comment .= ". Split is percent, payment amount is: $".$payment_amount.". Payment ok, ".($payment_amount == $trial_amount ? "trial payment," : "")." member: ".$s_member_id." upgraded to ".$membership_name_ipn;
                      if ( $pmt_type=="echeck")
                      {
                        if ($allowecheck==1)	{										
                          $query="update members set membership_id='$membership_id_new', echeck='1' where id='$s_member_id'"; 
                        }else {
                          $query="update members set membership_id='$membership_id_new', echeck='2' where id='$s_member_id'"; 
                        }
                      }
                      else
                      {
                        $query="update members set membership_id='$membership_id_new' where id='$s_member_id'"; 
                      }
                      $q->query($query);

                      updateHistory($s_member_id, $membership_id, true);

                    }else{
                      $comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".($price * $jv_amount/100).". Payment one not valid";
                      $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."',session_id='$custom'");
                      die("Fraud attempt payment 2 split");
                    }
                  }else{
                    $comment .= "affiliate is ".($jv == 0 ? "not jv. using default payment value: $".$jv_amount : "jv: ".$jv." using jv payment value: $".$jv_amount);
                    if ($payment_amount == number_format($jv_amount,2,".", "") || $payment_amount == $trial_amount){
                      $comment .= ". Split is full amount split, payment amount is: $".$payment_amount.". Payment ok, member: ".$s_member_id." upgraded to ".$membership_name_ipn;
                      if ( $pmt_type=="echeck")
                      {
                        if ($allowecheck==1)	{										
                          $query="update members set membership_id='$membership_id_new', echeck='1' where id='$s_member_id'"; 
                        }else {
                          $query="update members set membership_id='$membership_id_new', echeck='2' where id='$s_member_id'"; 
                        }
                      }
                      else
                      {
                        $query="update members set membership_id='$membership_id_new' where id='$s_member_id'"; 
                      }
                      $q->query($query);

                      updateHistory($s_member_id, $membership_id, true);

                    }else{
                      $comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".$jv_amount.". Payment one not valid";
                      $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."',session_id='$custom'");
                      die("Fraud attempt pament 2 full split");
                    }
                  }
                }
              }
            }
            else
            {
              $comment .= ", no affiliate. ";
              $emailsubject=get_setting("sales_email_subject");
              $emailbody=get_setting("admin_sale_email");
              $query="select * from tags";
              $q3->query($query);
              while ($q3->next_record())
              {
                $emailsubject=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailsubject);
                $emailbody=str_replace("{".$q3->f("title")."}", $q2->f($q3->f("field")), $emailbody);

              }

              $emailbody=str_replace("{product}", $product_display_name, $emailbody);
              $emailbody=str_replace("{email}", $_POST['payer_email'], $emailbody);
              $emailbody=str_replace("{first_name}", $_POST['first_name'], $emailbody);
              $emailbody=str_replace("{last_name}", $_POST['last_name'], $emailbody);
              $emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);

              mwg_mail(get_setting('webmaster_contact_email'), $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
              if($price == $payment_amount || $payment_amount == $trial_amount || (isset($mc_amount1) && $mc_amount1 == '0.00' && isset($trial_amount) && $trial_amount == '0.00')){
                $comment .= "Payment amount: $".$price.", Price ok, member: ".$s_member_id." upgraded to: $".$membership_name_ipn;
                if ( $pmt_type=="echeck")
                {
                  if ($allowecheck==1)		{									
                    $query="update members set membership_id='$membership_id_new', echeck='1' where id='$s_member_id'"; 
                  }else {
                    $query="update members set membership_id='$membership_id_new', echeck='2' where id='$s_member_id'"; 
                  }
                }
                else
                {
                  $query="update members set membership_id='$membership_id_new' where id='$s_member_id'";

                }
                $q->query($query);

                updateHistory($s_member_id, $membership_id, true);

              }else{
                $comment .= "The payment amount, $".$payment_amount.", did not match database value: $".$price.". Member not upgraded.";
                $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."',session_id='$custom'");
                die("Fraud attempt payment one no aff");
              }

            }
            $query="update session set paid='$paid', paid_step2='$paid2' where session_id='$s_session'";
            $q->query($query);

          }

          $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='$comment',session_id='$custom',process_type='paypal',buyer_id='$s_member_id',affiliate_id='$affiliate_id'");

        }
        else
        {
          set_setting("txn_id", $txn_id);
          $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', txn_id='".$txn_id."', comment='IPN was called from IP:".getenv("REMOTE_ADDR").", duplicate Txn Id',session_id='$custom',process_type='paypal'");
        }

        // check that txn_id has not been previously processed
        // check that receiver_email is your Primary PayPal email
        // check that payment_amount/payment_currency are correct
        // process payment
      }
      else if (strcmp ($res, "INVALID") == 0) {
          if ($s_member_id != 0){
            $q->query("SELECT id, name, aff FROM members WHERE id='$s_member_id'");
            $q->next_record();
            $member_fraud = "Suspect member id:".$q->f("id").", name: ".$q->f("name").", referal of id: ".$q->f("aff");
          }else 
            $member_fraud = "";
          $q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$txn_id."', comment='IPN was called from IP:".getenv("REMOTE_ADDR").", Paypal returned invalid status. ".$member_fraud."',session_id='$custom'");
          die();
          // log for manual investigation
        }
    }
    fclose ($fp);
  }
  set_setting("txn_id", $txn_id); 
