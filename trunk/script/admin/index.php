<?php 
include("inc.top.php");
if ($nogd==1) {?> <script language="Javascript"> alert("GD library is not installed/enabled .Signup Setting using graphics cannot be enabled");</script> <?php }
$q2=new Cdb;
$chck_funtions = '';
	$t->set_file("content", "admin.settings.html");
	$t->set_file("setting", "admin.settings.row.html");
	$t->set_file("settingcategory", "admin.settings.category.row.html");
	$query="select * from settings where name='old_aff'";
$q->query($query);
$q->next_record();
		$t->set_var("setting_box", '<input type="hidden" name="'.$q->f("name").'" id="'.$q->f("name").'" value="'.$q->f("value").'">');
		$t->set_var("setting_description", '');
		$t->parse("settings_list", "setting", true);
	
	$query="select * from settings where name!='give_oto_jv' and box_type!='hidden' and name not like '%_email%' or id=13 or id=11 or id=9 order by cat, rank, id";
	$q->query($query);
	$category='';
	$first = 0;
	$table_close = '';
	while ($q->next_record())
	{
		$t->set_var("sett",$q->f("id"));
		if ($category!=$q->f("cat"))
		{
			if ($first != 0){
				$table_close = "</td></tr>";
			}
			$category=$q->f("cat");
			$cat_first_word = explode(" ",$category);
			$chck_funtions .= "display_tr(document.getElementById('cat_".$cat_first_word[0]."'));";
			$t->set_var("name", $cat_first_word[0]);
			$t->set_var("table_close", $table_close);
			$t->set_var("setting_category", $category);
			$t->parse("settings_list", "settingcategory", true);
		}
		$first = 1;
		if ($q->f("box_type")=="textbox")
		{
			$set='<textarea name="'.$q->f("name").'" cols="50" rows="6">'.stripslashes($q->f("value")).'</textarea>';
			$desc=$q->f("description");
			
		}
		if ($q->f("box_type")=="input")
		{
			$set='<input type="text" name="'.$q->f("name").'" id="'.$q->f("name").'" value="'.stripslashes($q->f("value")).'" size="40">';
			$desc=$q->f("description");
			if ($q->f('name') == 'auth_login'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_auth_login = $q->f('id');
			}
			
			if ($q->f('name') == 'auth_key'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_auth_key = $q->f('id');
			}
			if ($q->f('name') == 'auth_login_arb'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_auth_login_arb = $q->f('id');
			}
			if ($q->f('name') == 'auth_key_arb'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_auth_key_arb = $q->f('id');
			}
			if ($q->f('name') == 'auth_hash'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_auth_hash = $q->f('id');
			}
			if ($q->f('name') == 'sid'){
				if (!$accept_2co_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_sid = $q->f('id');
			}
			if ($q->f('name') == 'secret_key_2co'){
				if (!$accept_2co_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_secret_key_2co = $q->f('id');
			}
			if ($q->f('name') == 'quantity'){
				if (!$accept_2co_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_quantity = $q->f('id');
			}
			if ($q->f('name') == 'vendor_id'){
				if (!$accept_clickbank_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_vendor_id = $q->f('id');
			}
			if ($q->f('name') == 'secret_key'){
				if (!$accept_clickbank_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_secret_key = $q->f('id');
			}
			if ($q->f('name') == 'paypal_email'){
				if (!$accept_paypal_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_paypal_email = $q->f('id');
			}
			if ($q->f('name') == 'paypal_currency'){
				if (!$accept_paypal_chk) $t->set_var("disp_".$q->f('id'),'none');
				$paypal_currency = $q->f('id');
			}
			if ($q->f('name') == 'txn_id'){
				if (!$accept_paypal_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_txn_id = $q->f('id');
			}
			if ($q->f('name') == 'mail_interval'){
				if (!$view_stats_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_mail_interval .= $q->f('id')."','";
			}
			if ($q->f('name') == 'mail_levels'){
				if (!$view_stats_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_mail_interval .= $q->f('id')."','";
			}
			if ($q->f('name') == 'view_downline_levels'){
				if (!$view_downline_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_view_downline_levels .= $q->f('id');
			}
			if ($q->f("name") == 'activation_link'){
				$desc = $q->f('description');
				$set = '';
			}
			
		}
		if ($q->f("box_type")=="checkbox")
		{
			
			if ($q->f("value")==1)
			$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked>';
			else $set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1">';
			$desc=$q->f("description");
			
			if ($q->f('name') == 'cb_popup'){
				if (!$accept_clickbank_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_cb_popup = $q->f('id');
			}
			if ($q->f('name') == 'cb_invisible'){
				if (!$accept_clickbank_chk) $t->set_var("disp_".$q->f('id'),'none');
				$id_cb_invisible = $q->f('id');
			}
			
			if ($q->f('name') == 'accept_auth'){
				if ($q->f("value")==1){
					$accept_auth_chk = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{accept_auth_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{accept_auth_fct()}">';
					$accept_auth_chk = 0;
				}
				
			}
			if ($q->f('name') == 'auth_test2'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$auth_test2 = $q->f('id');
			}
			if ($q->f('name') == 'auth_one_click'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$auth_one_click = $q->f('id');
			}
			if ($q->f('name') == 'use_aim'){
				
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				if($q->f("value")==1) $set='<input name="use_aim" id="use_aim" value="1" checked type="checkbox" onclick="if(document.getElementById(\'enable_oto_paid_signup_1\').checked==true) { document.getElementById(\'enable_oto_paid_signup_1\').checked=false;document.getElementById(\'enable_oto_paid_signup_0\').checked=true;alert(\'Choose Flow was changed to the first option because the second option cannot be used with AIM\'); } if(document.getElementById(\'cut_signup\').checked==true) { document.getElementById(\'cut_signup\').checked=false;alert(\'Option to not collect password on signup page has been uncheked as it cannot work with AIM\'); }">';
				else  $set='<input name="use_aim" id="use_aim" value="1" type="checkbox" onclick="if(document.getElementById(\'enable_oto_paid_signup_1\').checked==true) { document.getElementById(\'enable_oto_paid_signup_1\').checked=false;document.getElementById(\'enable_oto_paid_signup_0\').checked=true;alert(\'Choose Flow was changed to the first option because the second option cannot be used with AIM\'); } if(document.getElementById(\'cut_signup\').checked==true) { document.getElementById(\'cut_signup\').checked=false;alert(\'Option to not collect password on signup page has been uncheked as it cannot work with AIM\'); }">';
				$use_aim = $q->f('id');
			}
			if ($q->f('name') == 'cut_signup'){		
				if($q->f("value")==1) $set='<input name="cut_signup" id="cut_signup" value="1" checked type="checkbox" onclick="if(document.getElementById(\'use_aim\').checked==true) { document.getElementById(\'cut_signup\').checked=false;alert(\'Cannot enable this option if AIM is enabled\'); }">';
				else  $set='<input name="cut_signup" id="cut_signup" value="1" type="checkbox" onclick="if(document.getElementById(\'use_aim\').checked==true) { document.getElementById(\'cut_signup\').checked=false;alert(\'Cannot enable this option if AIM is enabled\'); }">';
				$use_aim = $q->f('id');
			}
			if ($q->f('name') == 'auth_test'){
				if (!$accept_auth_chk) $t->set_var("disp_".$q->f('id'),'none');
				$auth_test = $q->f('id');
			}
			if ($q->f('name') == 'paypal_currency'){
				if (!$accept_paypal_chk) $t->set_var("disp_".$q->f('id'),'none');
				$paypal_currency = $q->f('id');
			}
			if ($q->f('name') == 'accept_clickbank'){
				if ($q->f("value")==1){
					$accept_clickbank_chk = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{accept_clickbank_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{accept_clickbank_fct()}">';
					$accept_clickbank_chk = 0;
				}
			}
			if ($q->f('name') == 'accept_2co'){
				if ($q->f("value")==1){
					$accept_2co_chk = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{accept_2co_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{accept_2co_fct()}">';
					$accept_2co_chk = 0;
				}
			}
			if ($q->f('name') == 'accept_paypal'){
				if ($q->f("value")==1){
					$accept_paypal_chk = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{accept_paypal_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{accept_paypal_fct()}">';
					$accept_paypal_chk = 0;
				}
			}
			if ($q->f('name') == 'ipblocker'){
				$id_ipblocker = $q->f('id');
				if ($q->f("value")==1){
					$ipblocker_chk = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{ipblocker_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{ipblocker_fct()}">';
					$ipblocker_chk = 0;
				}
			}
			if ($q->f('name') == 'view_stats'){
				$id_view_stats = $q->f('id');
				if ($q->f("value")==1){
					$view_stats_chk = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{view_stats_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{view_stats_fct()}">';
					$view_stats_chk = 0;
				}
			}
			if ($q->f('name') == 'jv_custom'){
				$id_jv_custom = $q->f('id');
				if ($q->f("value")==1){
					$jv_custom_memberships = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{jv_custom_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{jv_custom_fct()}">';
					$jv_custom_memberships = 0;
				}
			}
			if ($q->f('name') == 'view_downline'){
				$id_view_downline = $q->f('id');
				if ($q->f("value")==1){
					$view_downline_chk = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{view_downline_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{view_downline_fct()}">';
					$view_downline_chk = 0;
				}
			}
			
			if ($q->f('name') == 'view_stats_chk'){
				$id_view_stats_chk = $q->f('id');
				$set = '';
				$membership_arr = explode(',',$q->f("value"));
				$q2->query("SELECT id, name FROM membership ORDER BY rank");
				
				if ($view_stats_chk){
				
					$set .= "<tr id='view_stats_chk_tr'' style='display:;'><td>";
				}else{
					$set .= "<tr id='view_stats_chk_tr'' style='display:none;'><td>";
					$t->set_var("no_hr_".$q->f('id'),"none");
				}
				while ($q2->next_record()){
					if (in_array($q2->f("id"),$membership_arr)){
						$set .= "<input type='checkbox' name='membership_".$q2->f("id")."' id='membership_".$q2->f("id")."' value=1 checked>".$q2->f("name");
					}else{
						$set .= "<input type='checkbox' name='membership_".$q2->f("id")."' id='membership_".$q2->f("id")."' value=1>".$q2->f("name");
					}
				}
				$set .= "</td></tr>";
			}
			if ($q->f('name') == 'jv_custom_memberships'){
				$id_jv_custom_memberships = $q->f('id');
				$set = '';
				$membership_arr = explode(',',$q->f("value"));
				$q2->query("SELECT id, name FROM membership ORDER BY rank");
				
				if ($jv_custom_memberships){
				
					$set .= "<tr id='jv_custom_memberships_tr'' style='display:;'><td>";
				}else{
					$set .= "<tr id='jv_custom_memberships_tr'' style='display:none;'><td>";
					$t->set_var("no_hr_".$q->f('id'),"none");
				}
				while ($q2->next_record()){
					if (in_array($q2->f("id"),$membership_arr)){
						$set .= "<input type='checkbox' name='jv_custom_membership_".$q2->f("id")."' id='jv_custom_membership_".$q2->f("id")."' value=1 checked>".$q2->f("name");
					}else{
						$set .= "<input type='checkbox' name='jv_custom_membership_".$q2->f("id")."' id='jv_custom_membership_".$q2->f("id")."' value=1>".$q2->f("name");
					}
				}
				$set .= "</td></tr>";
			}
			if ($q->f('name') == 'send_mail'){
				$id_view_stats = $q->f('id');
				if ($q->f("value")==1){
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{email_downline_fct()}">';
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{email_downline_fct()}">';
				}
				$desc=$q->f("description");
			}
			if ($q->f('name') == 'free_signup'){
				if ($q->f("value")==1){
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{free_signup_fct()}">';
	
				}else{ 
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{free_signup_fct()}">';
				}
				$desc=$q->f("description");
			}
		}
		if ($q->f("box_type")=="hidden")
		{
			$set='<input type="hidden" name="'.$q->f("name").'" value="'.$q->f("value").'">';
			$desc='';
		}
		if ($q->f("box_type")=="select" && $q->f("name") == "change_membership"){
			$set = '<select name="'.$q->f("name").'" >
			 <option>Chose membership</option>';
			$q2->query("SELECT name, id FROM membership WHERE active=1");
			while($q2->next_record()){
				if ($q2->f("id") == $q->f("value")) $selected = "selected";
				else $selected = "";
				$set .= '<option value="'.$q2->f("id").'" '.$selected.'>'.$q2->f("name").'</option>';
			}
			$set .= '</select>';
			$desc=$q->f("description");
		}
		if ($q->f("box_type")=="select" && $q->f("name") == "paypal_currency"){
			$set = '<select name="'.$q->f("name").'" >
			 <option>Chose currency</option>';
			$q2->query("SELECT name, short FROM currencies");
			while($q2->next_record()){
				if ($q2->f("short") == $q->f("value")) $selected = "selected";
				else $selected = "";
				$set .= '<option value="'.$q2->f("short").'" '.$selected.'>'.$q2->f("name").'</option>';
			}
			$set .= '</select>';
			$desc=$q->f("description");
						if ($q->f('name') == 'paypal_currency'){
				if (!$accept_paypal_chk) $t->set_var("disp_".$q->f('id'),'none');
				$paypal_currency = $q->f('id');
			}
		}
		
		if ($q->f("box_type")=="select" && $q->f("name") == "default_free"){
			$set = '<select name="'.$q->f("name").'" >
			 <option value="0">Chose membership</option>';
			$q2->query("SELECT name, id FROM membership WHERE active=1");
			while($q2->next_record()){
				if ($q2->f("id") == $q->f("value")) $selected = "selected";
				else $selected = "";
				$set .= '<option value="'.$q2->f("id").'" '.$selected.'>'.$q2->f("name").'</option>';
			}
			$set .= '</select>';
			$desc=$q->f("description");
		}
		
		if ($q->f("box_type")=="select" && $q->f("name") == "echeck"){
			$set = '<select name="'.$q->f("name").'" >
			 <option>Chose what to do with members that pay by echeck</option>';
			if ($q->f("value")==1) {$sel1="selected"; $sel2="";}
			if ($q->f("value")==2) {$sel1=""; $sel2="selected";}
			$set .= '<option value="1" '.$sel1.'>Treat them as if the payment was sucessfully completed</option>';
			$set .= '<option value="2" '.$sel2.'>Keep them from accessing the downloads until the echeck is cleared</option>';
			
			
			$set .= '</select>';
			$desc=$q->f("description");
		}
		$t->set_var("setting_box", $set);
		if ($q->f("name") == "enable_jv"){
			$desc = str_replace("{url}",get_setting("site_full_url"),$q->f("description"));
		}
		
		if ($q->f("box_type")=="select" && $q->f("name") == "jv_membership"){
			$set = '<select name="'.$q->f("name").'" >
			 <option>Chose membership</option>';
			$q2->query("SELECT name, id FROM membership WHERE active=1");
			while($q2->next_record()){
				if ($q2->f("id") == $q->f("value")) $selected = "selected";
				else $selected = "";
				$set .= '<option value="'.$q2->f("id").'" '.$selected.'>'.$q2->f("name").'</option>';
			}
			$set .= '</select>';
			$desc=$q->f("description");
		}
		if ($q->f("box_type")=="select" && $q->f("name") == "enable_bm_aff_link")
		{
			$set = '<select name="'.$q->f("name").'" >';
			$set .= '<option value="0" {sel0}> Do Not Display Affilaite Link</option>
  					<option value="1" {sel1}>Show Affiliate Link on all pages</option>
  					<option value="2" {sel2}>Show Affiliate Link Only on logged out pages</option>
 					 <option value="3" {sel3}>Show Affiliate Link Only in Members area</option>';
			
			$set .= '</select>';
			$set=str_replace("{sel".$q->f("value")."}", "selected", $set);
			$desc=$q->f("description");
		}
		if ($q->f("box_type")=="radio"){
			if ($q->f('name') == 'splitoption'){
				if ($q->f("value")==1)
				$set = '<input type="radio" name="splitoption" value="2">Pay Admin Then Affilitate <input type="radio" name="splitoption" value="1" checked>Pay Affiliate Then Admin';
				if ($q->f("value")==2)
				$set = '<input type="radio" name="splitoption" value="2" checked>Pay Admin Then Affilitate <input type="radio" name="splitoption" value="1">Pay Affiliate Then Admin';
				
				$desc=$q->f("description");
			}elseif ($q->f('name') == 'choose_aff'){
				if ($q->f("value")==1)
				$set = '<input type="radio" name="choose_aff" value="2">Current affiliate variable: <script>document.write(document.getElementById("affiliate_variable").value)</script> <input type="radio" name="choose_aff" value="1" checked>Old affiliate variabie: <script>document.write(document.getElementById("old_aff").value)</script>';
				if ($q->f("value")==2)
				$set = '<input type="radio" name="choose_aff" value="2" checked>Current affiliate variable: <script>document.write(document.getElementById("affiliate_variable").value)</script> <input type="radio" name="choose_aff" value="1">Old affiliate variabie: <script>document.write(document.getElementById("old_aff").value)</script>';
				
				$desc=$q->f("description");
			}elseif ($q->f('name') == 'enable_oto_paid_signup'){
				$id_enable_oto_paid_signup = $q->f('id');
				if ($q->f("value")==1)
				$set = '<input type="radio" name="enable_oto_paid_signup" id="enable_oto_paid_signup_0" value="0"> Member Pays, Signup form, Offer OTO1, Offer OTO2 <input type="radio" name="enable_oto_paid_signup" id="enable_oto_paid_signup_1" value="1" checked onclick="if(document.getElementById(\'use_aim\').checked==true) {document.getElementById(\'use_aim\').checked=false;alert(\'You cannot use this option with AIM and it was unchecked\');}"> Member Pays, Offer OTO1, Offer OTO2, Member Signup form';
				if ($q->f("value")==0 || $q->f("value")=='')
				$set = '<input type="radio" name="enable_oto_paid_signup" id="enable_oto_paid_signup_0" value="0" checked> Member Pays, Signup form, Offer OTO1, Offer OTO2 <input type="radio" name="enable_oto_paid_signup" id="enable_oto_paid_signup_1" value="1" onclick="if(document.getElementById(\'use_aim\').checked==true) {document.getElementById(\'use_aim\').checked=false;alert(\'You cannot use this option with AIM and it was unchecked\');}"> Member Pays, Offer OTO1, Offer OTO2, Member Signup form';
				
				$desc=$q->f("description");
			}
		}
		if ($q->f("box_type")=="select" && $q->f("name") == "blockfor"){
			$id_blockfor = $q->f('id');
			if (!$ipblocker_chk) $t->set_var("disp_".$q->f('id'),'none');
			$a="sel".$q->f("value");	
			$$a="selected";
			$set = '<select name="'.$q->f("name").'" >';
			$set .= '<option value="1" '.$sel1.'>With in 1 hour</option>';
			$set .= '<option value="2" '.$sel2.'>With in 1 day</option>';
			$set .= '<option value="3" '.$sel3.'>With in 2 days</option>';
			$set .= '<option value="4" '.$sel4.'>With in 1 month</option>';
			$set .= '<option value="5" '.$sel5.'>Ever</option>';
			
			$set .= '</select>';
			$desc=$q->f("description");
		}
		$t->set_var("setting_box", $set);
		$t->set_var("setting_description", stripslashes(stripslashes($desc)));
		$t->parse("settings_list", "setting", true);
	}
		
			$chck_funtions .= "accept_auth_fct('$id_auth_login','$id_auth_key','$id_auth_hash','$id_auth_login_arb','$id_auth_key_arb','$auth_test','$use_aim','$auth_one_click','$auth_test2');accept_2co_fct('$id_sid','$id_secret_key_2co','$id_quantity');accept_clickbank_fct('$id_cb_popup','$id_cb_invisible','$id_vendor_id','$id_secret_key');accept_paypal_fct('$id_paypal_email','$id_txn_id', '$paypal_currency');ipblocker_fct('$id_blockfor');view_stats_fct('$id_view_stats','".$id_view_stats_chk."');email_downline_fct('".substr($id_mail_interval,0,-2).");view_downline_fct('$id_view_downline_levels');free_signup_fct('$id_enable_oto_paid_signup');jv_custom_fct('$id_jv_custom','".$id_jv_custom_memberships."');";
			$t->set_var('view_stats_fct()',"view_stats_fct('$id_view_stats','".$id_view_stats_chk."')");
			$t->set_var('email_downline_fct()',"email_downline_fct('".substr($id_mail_interval,0,-2).")");
			$t->set_var('view_downline_fct()',"view_downline_fct('$id_view_downline_levels')");
			$t->set_var('ipblocker_fct()',"ipblocker_fct('$id_blockfor')");
			$t->set_var('free_signup_fct()',"free_signup_fct('$id_enable_oto_paid_signup')");
			$t->set_var('accept_paypal_fct()',"accept_paypal_fct('$id_paypal_email','$id_txn_id', '$paypal_currency')");
			$t->set_var('accept_clickbank_fct()',"accept_clickbank_fct('$id_cb_popup','$id_cb_invisible','$id_vendor_id','$id_secret_key')");
			$t->set_var('accept_2co_fct()',"accept_2co_fct('$id_sid','$id_secret_key_2co','$id_quantity')");
			$t->set_var('accept_auth_fct()',"accept_auth_fct('$id_auth_login','$id_auth_key','$id_auth_hash','$id_auth_login_arb','$id_auth_key_arb','$auth_test','$use_aim','$auth_one_click','$auth_test2')");
			$t->set_var('jv_custom_fct()',"jv_custom_fct('$id_jv_custom','".$id_jv_custom_memberships."')");
			$table_close = "</td></tr>";
			$t->set_var("table_close", $table_close);
			$t->set_var("chck_funtions", $chck_funtions);
	
include("inc.bottom.php");
?>