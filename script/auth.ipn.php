<?php
include("inc.all.php");
$q2=new cdb;
$q3=new cdb;
$q4=new cdb;
if ($x_response_code == 1 && $x_subscription_paynum>1){
	$q->query("SELECT * FROM session WHERE subscriber_id='$x_subscription_id' AND subscriber_id!=''");
	$q->next_record();
	$custom = $q->f("session_id");
	$s_session = $q->f("session_id");
	$s_member_id = $q->f("member_id");
	$s_product_id = $q->f("product_id");
	$s_ip=$q->f("ip");
	$aff_id=$q->f("affiliate_id");
	$payment_amount = $x_amount;
	process_sale($payment_amount, $s_member_id ,$s_product_id, 0, $s_product_id, $s_member_id, $custom);
	$comment .= "New payment: ";
	$paid2=1;
	$paid=1;
	$query="select * from products where id='$s_product_id'";
	$q->query($query);
	$q->next_record();
	$price = $q->f("price");
	if ($q->f("times_trial_auth")){
		$trial_amount = $q->f("trial_auth_amount");
	}
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
		$aff_email=$q->f("email");
		$aff_s_date=$q->f("s_date");
		$jv = $q->f("jv");
		$q->query("SELECT * FROM levels WHERE membership_id='$aff_membership_id' AND product_id='$s_product_id'");
		$nums=$q->nf();
		if ($q->nf() == 0 || $q->nf() == 1)
		{
			$q->next_record();
			$paytype=$q->f("paytype");
			$value=$q->f("value");
			$price=number_format($price,2,".", "");
			if($price == $payment_amount || ($payment_amount == $trial_amount && isset($trial_amount))){
				$comment .= "No level, or non split level found, only one payment required, payment amount: ".$price.". member: ".$s_member_id." upgraded to ".$membership_name_ipn;
				$query="update members set membership_id='$membership_id_new' where id='$s_member_id'";
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
					} elseif ($trial_amount==$payment_amount && isset($trial_amount)) {
						if ($paytype=="percent") $commsval=$jv_amount*$trial_amount/100;
						if ($paytype=="full_amount") $commsval=$jv_amount;
					}
					$emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
					$emailbody=str_replace("{value}", $commsval, $emailbody);
					if($jv_amount != 0)
					@mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
				}
			}else{
				$comment .= "No level, or non split level found, only one payment required, but the payment amount, ".$payment_amount.", did not match database value, ".$price.". Member not upgraded.";
				$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."'");
				die("Fraud attempt payment no level or one");
			}
		}
		else
		{
			if (get_setting("sales_email")==1 && $paid == 1 && $paid2 == 0)
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
				@mail($aff_email, $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
			}
			if ($paid == 1 && $paid2 == 0){
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
					if ($payment_amount == number_format(($price * $jv_amount/100),2,".", "") || ($payment_amount == $trial_amount && isset($trial_amount))){
						$comment .= ". Split is percent, payment amount is: $".$payment_amount.". payment ok, waiting for second payment, from member: $s_member_id";
					}else{
						$comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".($price * $jv_amount/100).". Payment not ok";
						$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."'");
						die("Fraud attempt first payment percent split ");
					}
				}else{
					$comment .= ". Affiliate is ".($jv == 0 ? "not jv. using default payment value: $".$jv_amount : "jv: ".$jv." using jv payment value: $".$jv_amount);
					if ($payment_amount == $jv_amount || ($payment_amount == $trial_amount && isset($trial_amount))){
						$comment .= ". Split is full amount, amount is: $".$payment_amount.". payment ok, waiting for second payment, from member: $s_member_id";
					}else{
						$comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".$jv_amount.". Payment not ok.";
						$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."'");
						die("Fraud attempt first payment full split");
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
					$query="update members set membership_id='$membership_id_new' where id='$s_member_id'";
					$q->query($query);
					updateHistory($s_member_id, $membership_id, true);
					$comment.="Second payment is 0, member upgraded";
					$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment',buyer_id='$s_member_id',affiliate_id='$aff_id'");
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
					if ($payment_amount == number_format(($price * $jv_amount/100),2,".", "") || ($payment_amount == $trial_amount && isset($trial_amount))){
						$comment .= ". Split is percent, payment amount is: $".$payment_amount.". Payment ok, ".($payment_amount == $trial_amount ? "trial payment," : "")." member: ".$s_member_id." upgraded to ".$membership_name_ipn;
						$query="update members set membership_id='$membership_id_new' where id='$s_member_id'";
						$q->query($query);
						updateHistory($s_member_id, $membership_id, true);
					}else{
						$comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".($price * $jv_amount/100).". Payment one not valid";
						$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."'");
						die("Fraud attempt payment 2 split");
					}
				}else{
					$comment .= "affiliate is ".($jv == 0 ? "not jv. using default payment value: $".$jv_amount : "jv: ".$jv." using jv payment value: $".$jv_amount);
					if ($payment_amount == number_format($jv_amount,2,".", "") || ($payment_amount == $trial_amount && isset($trial_amount))){
						$comment .= ". Split is full amount split, payment amount is: $".$payment_amount.". Payment ok, member: ".$s_member_id." upgraded to ".$membership_name_ipn;
						$query="update members set membership_id='$membership_id_new' where id='$s_member_id'";
						$q->query($query);
						updateHistory($s_member_id, $membership_id, true);
					}else{
						$comment .= ". Payment amount was: $".$payment_amount.", it should have been: $".$jv_amount.". Payment one not valid";
						$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."'");
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
		$emailbody=str_replace("{email}", $x_email, $emailbody);
		$emailbody=str_replace("{first_name}", $x_first_name, $emailbody);
		$emailbody=str_replace("{last_name}", $x_last_nam, $emailbody);
		$emailbody=str_replace("[sitename]", get_setting("site_name"), $emailbody);
		@mail(get_setting('webmaster_contact_email'), $emailsubject, $emailbody, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">".(get_setting("sales_email_cc") ? "\r\nCc: ".get_setting('sales_email_cc_adr') : ""));
		if($price == $payment_amount || ($payment_amount == $trial_amount && isset($trial_amount))){
			$comment .= "Payment amount: $".$price.", Price ok, member: ".$s_member_id." upgraded to: $".$membership_name_ipn;
			$query="update members set membership_id='$membership_id_new' where id='$s_member_id'";
			$q->query($query);
			updateHistory($s_member_id, $membership_id, true);
		}else{
			$comment .= "The payment amount, $".$payment_amount.", did not match database value: $".$price.". Member not upgraded.";
			$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment ".'. Attempt by member: '.$s_member_id."'");
			die("Fraud attempt payment one no aff");
		}
	}
	$query="update session set paid='$paid', paid_step2='$paid2' where session_id='$s_session'";
	$q->query($query);
	$q->query("INSERT INTO payment_log SET stamp='".time()."', ip='$s_ip', product='".$product_display_name."', txn_id='".$x_trans_id."', comment='$comment',buyer_id='$s_member_id',affiliate_id='$aff_id'");
}elseif($x_response_code != 1 && $x_subscription_paynum==1){
	$q->query("SELECT * FROM session WHERE subscriber_id='$x_subscription_id' AND subscriber_id!=''");
	$q->next_record();
	$custom = $q->f("session_id");
	$s_session = $q->f("session_id");
	$s_member_id = $q->f("member_id");
	$s_product_id = $q->f("product_id");
	$aff_id=$q->f("affiliate_id");
	$s_ip=$q->f("ip");
	$payment_amount = $x_amount;	
	if($q->nf()){
		if (get_setting("delete_user")==1 && get_setting("cancel_new_system")!=1) $query="delete from members where id='$s_member_id'";
		else
		if (get_setting("suspend_user")==1 && get_setting("cancel_new_system")!=1) $query="update members set suspended='1' where id ='$s_member_id'";
		else
		if (get_setting("change_membership")!="xref_none" && get_setting("cancel_new_system")!=1) {
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
				updateHistory($s_member_id, $product_membership);
			} elseif ($current_rank==$product_rank) {
				$query="SELECT * FROM products where id='$s_product_id'";
				$q->query($query);
				$q->next_record();
				$membership_h_id=$q->f("membership_id");
				updateHistory($s_member_id, $membership_h_id);
				$query="SELECT history FROM members WHERE id='$s_member_id'";
				$q4->query($query);
				$q4->next_record();
				$history=$q4->f('history');
				$history_exp=explode(",", $history);
				$max_rank=max($history_exp);
				$query="SELECT * FROM membership WHERE rank='$max_rank'";
				$q4->query($query);
				$q4->next_record();
				$new_membership=$q4->f("id");
				$query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
				$q->query($query);
			}
		} else {
			$query="SELECT * FROM products WHERE id='$s_product_id'";
			$q->query($query);
			$q->next_record();
			$product_membership=$q->f("membership_id");
			updateHistory($s_member_id, $product_membership);
			$query="SELECT history FROM members WHERE id='$s_member_id'";
			$q4->query($query);
			$q4->next_record();
			$history=$q4->f('history');
			$history_exp=explode(",", $history);
			$max_rank=max($history_exp);
			$query="SELECT * FROM membership WHERE rank='$max_rank'";
			$q4->query($query);
			$q4->next_record();
			$new_membership=$q4->f("id");
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
}elseif ($x_type == 'credit'){
	$q->query("SELECT * FROM session WHERE session_id like '$x_invoice_num%'");
	$q->next_record();
	$custom = $q->f("session_id");
	$s_session = $q->f("session_id");
	$s_member_id = $q->f("member_id");
	$s_product_id = $q->f("product_id");
	$aff_id=$q->f("affiliate_id");
	$s_ip=$q->f("ip");
	$payment_amount = $x_amount;	
	if($q->nf()){
		if (get_setting("delete_user")==1 && get_setting("cancel_new_system")!=1) {
			$query="delete from members where id='$s_member_id'";
			$q->query($query);
		}else
		if (get_setting("suspend_user")==1 && get_setting("cancel_new_system")!=1){
			$query="update members set suspended='1' where id ='$s_member_id'";
			$q->query($query);
		}else
		if (get_setting("cancel_new_system")==1 ) {		
				$query="SELECT * FROM products where id='$s_product_id'";
				$q->query($query);
				$q->next_record();
				$membership_h_id=$q->f("membership_id");
				updateHistory($s_member_id, $membership_h_id);
				if(!is_integer(get_setting("change_membership"))){
					$query="SELECT history FROM members WHERE id='$s_member_id'";
					$q4->query($query);
					$q4->next_record();
					$history=$q4->f('history');
					$history_exp=explode(",", $history);
					$max_rank='';
					$new_membershi='';
					foreach ($history_exp as $val){
						$q4->query("SELECT rank from membership WHERE id='".$val."'");
						$q4->next_record();
						if($q4->f("rank")>$max_rank){
							$max_rank=$q4->f("rank");
							$new_membership=$val;
						}
					}
					$query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
					$q->query($query);
				}elseif(get_setting("change_membership")>0){
					$new_membership=get_setting("change_membership");
					$query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
					$q->query($query);
				}else{
					$new_membership=get_setting("default_free");
					$query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
					$q->query($query);
				}
		} else {
			if(get_setting("change_membership")>0){
					$new_membership=get_setting("change_membership");
					$query="update members set membership_id='".$new_membership."' where id='$s_member_id'";
					$q->query($query);
			}
		
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
	
}
?>