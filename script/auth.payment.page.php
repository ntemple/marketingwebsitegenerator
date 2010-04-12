<?php 
include("inc.all.php");
$q2=new Cdb;
$q3=new Cdb;
	$ar_host=parse_url(get_setting("site_full_url"));
	$host=$ar_host["host"];
	$path=$ar_host["path"];
	$host=str_replace("www","",$host);
		$t->set_file("content", "auth.payment.page.html");
		$t->set_file("signuplist", "signup.row.html");
		$t->set_file("signuplist_b", "signup.row.html");
		$t->set_file("confirmpass", "confirm.pass.html");
		//instead of signup.kit
                $year = date("Y", time());
                $i = 0;
                while ($i < 21) {
                    $year_options .= '<option value="'.($year+$i).'">'.($year+$i).'</option><br>';
                    $i++;
                }
                $t->set_var("year_options", $year_options);
			
		
$query="SELECT * FROM products WHERE physical='1'";
$q2->query($query);
$q2->next_record();
$exist_physical=$q2->nf();
$query="SELECT * FROM signup_settings WHERE field='country'";
$q2->query($query);
$q2->next_record();
if ($exist_physical>0 && $q2->nf()<1) {
	
		$query="SELECT position FROM signup_settings ORDER BY position DESC LIMIT 1";
		$q->query($query);
		$q->next_record();
		$position=$q->f('position');
		$position++;
		$query="insert into signup_settings (field, description, position, atsignup, required) values ('country','Country', '$position', '1', '1')";
		$q->query($query);
}
if ($exist_physical>0 && get_setting("ask_country_on_product")!=1) {
if ($q2->f("atsignup")!=1 || $q2->f("required")!=1) {
	$query="UPDATE signup_settings SET atsignup='1', required='1' WHERE field='country'";
	$q2->query($query);
}
}
if ($_GET['double_email']==1) $error.='<p align="center"><b><font color="#FF0000">The email address you filled in is already in our database.</font></b></p>';
if (get_setting("enable_captcha")==1)	{
	require_once("lib/hn_captcha.class.x1.php");
	if ($_GET['captcha']==1) { $error.='<script language="Javascript">alert("Captcha code incorrectly entered");</script>';
	}
	$segs=explode("/",$_SERVER['SCRIPT_FILENAME']);
	$segs[count($segs)-1]='';
	$folders=implode("/",$segs);
	$CAPTCHA_INIT = array(
        'tempfolder' => $folders."_tmp/", // string: absolute path (with trailing slash!) to a writeable tempfolder which is also accessible via HTTP!
        'TTF_folder' => $folders."fonts/", // string: absolute path (with trailing slash!) to folder which contains your TrueType-Fontfiles.
                                // mixed (array or string): basename(s) of TrueType-Fontfiles
//			'TTF_RANGE'      => array('comic.ttf','impact.ttf','LYDIAN.TTF','MREARL.TTF','RUBBERSTAMP.TTF','ZINJARON.TTF'),
			'TTF_RANGE'      => array('comic.ttf','impact.ttf'),
            'chars'          => 5,       // integer: number of chars to use for ID
            'minsize'        => 20,      // integer: minimal size of chars
            'maxsize'        => 30,      // integer: maximal size of chars
            'maxrotation'    => 25,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30
            'noise'          => TRUE,    // boolean: TRUE = noisy chars | FALSE = grid
            'websafecolors'  => FALSE,   // boolean
            'refreshlink'    => TRUE,    // boolean
            'lang'           => 'en',    // string:  ['en'|'de']
            'maxtry'         => 3,       // integer: [1-9]
            'badguys_url'    => '/',     // string: URL
            'secretstring'   => 'A very, very secret string which is used to generate a md5-key!',
            'secretposition' => 24,      // integer: [1-32]
            'debug'          => FALSE,
	);
	$captcha =& new hn_captcha_X1($CAPTCHA_INIT);
	$t->set_var("captcha",$captcha->display_form());
}
if (get_setting("enable_arp")==1 && get_setting("arp_in_use_type")==1){
	$query="select * from autoresponder_config where arp_id='".get_setting("arp_in_use")."' order by id";
	$q->query($query);
	$switch = false;
	while ($q->next_record()){
		if (($q->f("field") == "url" && strpos($q->f('value'),'prosender')) || ($q->f("field") == "url" && strpos($q->f('value'),'aweber'))){
			$t->set_var("request_email","");
			
			$switch = true;
		}
		if ($q->f("field") == "first_name")
			$first_name_awb = $q->f("value");
	}
}
$validation_string = "
err = 'The following fields are not correct filled:\\n';
".(get_setting('cut_signup') && !$switch ? "
if (document.form1.first_name.value == ''){
	err += 'No First Name.\\n';
}" :(get_setting('cut_signup') && $switch ? "
if (document.form1.$first_name_awb.value == ''){
	err += 'No First Name.\\n';
}" 
		:"
if (document.form1.password.value == ''){
	err += 'No password.\\n';
}else if (document.form1.cpass.value != document.form1.password.value){
	err += 'Passwords do not match.\\n';
}
if (document.form1.cardNumber.value == ''){
	err += 'No Credit Card.\\n';
	}
if (document.form1.year.value == ''){
	err += 'No Expiration Year.\\n';
	}
		"));
		if (get_setting("show_promo_signup")==1)
		{
			$t->set_var("promo", "Promotion code:</td><td> <input type=text size='29' name=promo>");
		}
		if (get_setting("signup_with_code")==1)
		{
			$validation_string .= ($_GET['code'] == md5(get_setting("secret_string").get_setting("signup_code")) ? "//code=ok" : "//code=0");
			$t->set_var("request","makeRequest_get('test_promo_code.php?'+str_vars,code=1);");
			
			FFileRead("templates/signup.code.html", $signupcode);
			$t->set_var("code_signup", $signupcode);
			$t->set_var("text_for_signup_code", get_setting("text_for_signup_code"));
		}
		else $t->set_var("request","");
		
		
		if (get_setting("enable_arp")==1 && get_setting("arp_in_use_type")==1){
			$t->set_var("form2",'<form id="form2" name="form2" method="{arp_method}" action="{arp_action}" target="iframe" style="display:none">
              <input type="hidden" id="interval_length" name="interval_length" value="" />
              <input type="hidden" id="startDate" name="startDate" value="" />
              <input type="hidden" id="totalOccurrences" name="totalOccurrences" value="" />
              <input type="hidden" id="trialOccurrences" name="trialOccurrences" value="" />
              <input type="hidden" id="trialAmount" name="trialAmount" value="" />
              <input type="hidden" id="amount" name="amount" value="" />
              <input type="hidden" id="custom" name="custom" value="" />
              <input type="hidden" id="interval_unit" name="interval_unit" value="" />
              {test}
                  <tr style="display:none"> 
                    <td class="LabelColCC">Card Number: </td>
                    <td class="DataColCC"> 
                      <input size="27" type="text" id="cardNumber" name="cardNumber" value=""/>
                      *&nbsp;<span class="Comment">(enter number without spaces 
                      or dashes)</span></td>
                  </tr>
                  <tr style="display:none"> 
                    <td class="LabelColCC">Expiration Date: </td>
                    <td class="DataColCC"> 
                      <select name="month">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                      <select name="year">
                        <option value=""></option>
                        <option  value="2009">2009</option>
                        <option  value="2010">2010</option>
                        <option  value="2011">2011</option>
                        <option  value="2012">2012</option>
                        <option  value="2013">2013</option>
                        <option  value="2014">2014</option>
                        <option  value="2015">2015</option>
                        <option  value="2016">2016</option>
                        
                      </select>
			
			{arp_subscription}
'.($switch ? "<table style='display:none'>{signup_list_b}<tr><td align=\"right\">{description_country_b}: &nbsp;</td><td>{shiping_country_list_b}{required_country_b}</td></tr>{promo1}{code_signup1}{chk}{captcha1}</table>" : "").'</form>
			<iframe name="iframe" style="display:none">
			</iframe>');
			
			$t->set_var("form2items",($switch ? "copy_fields('form1','form2');" : "")."document.form2.{first_name_noaweber}.value = document.form1.{first_name_value}.value;
			document.form2.{email_value}.value = document.form1.{arp_email_value}.value;
			
			if (validate_form()){
				//document.form1.cardNumber.value = '';
				document.form2.submit();
				document.getElementById('div_form').style.display = 'none';
				document.getElementById('div_wait').style.display = '';
				".(get_setting("cut_signup")==0 && $switch  ? "document.form1.password.value='';document.form1.cpass.value='';" : "")."
			".($switch ? "//" : "" )."setTimeout('document.form1.submit()',10000);
}");
			
			$query="select * from autoresponder_config where arp_id='".get_setting("arp_in_use")."' order by id";
			$q->query($query);
			$arp_subscription='';
			while ($q->next_record())
			{
				
				if (get_setting("enable_oto_paid_signup")==1 && get_setting("free_signup")!=1){
					if ($q->f("field")!='' && $q->f("field")!="email" && $q->f("field")!="first_name" && $q->f("field")!="method" && $q->f("field")!="url" && $q->f("field")!="arp_name")
						
						if ($q->f("field") == "redirect" && $switch){
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.get_setting("site_full_url").'member.area.in.php">';
						}elseif($q->f("field")== "web_redirect"){ 
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.get_setting("site_full_url").'member.area.in.php">';
						}elseif($q->f("field")== "ARThankyouURL"){ 
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.get_setting("site_full_url").'member.area.in.php">';
						}else
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.$q->f("value").'">';
				}else{
					if ($q->f("field")!='' && $q->f("field")!="email" && $q->f("field")!="first_name" && $q->f("field")!="method" && $q->f("field")!="url" && $q->f("field")!="arp_name")
						
						if ($q->f("field") == "redirect" ){
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.get_setting("site_full_url").'oto.php">';
						}elseif($q->f("field")== "web_redirect"){ 
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.get_setting("site_full_url").'oto.php">';
						}elseif($q->f("field")== "ARThankyouURL"){ 
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.get_setting("site_full_url").'oto.php">';
						}else
							$arp_subscription.='<input type="hidden" name="'.$q->f("field").'" value="'.$q->f("value").'">';
				}
				
				if ($switch){
					if ($q->f("field")=="email"){
						$t->set_var("arp_email_value",$q->f("value"));
						$arp_email_value = $q->f("value");
					}
					if ($q->f("field")=="first_name"){
						$t->set_var("first_name_value",$q->f("value"));
						$arp_first_name_value = $q->f("value");
					}
					
					if ($q->f("field")=="url") $t->set_var("form_switch",$q->f("value"));
					$t->set_var("arp_action", "do.signup.php");
					if ($q->f("field")=="method") $t->set_var("send_method", ($q->f("value") == 1 ? "GET" : "POST"));
					$t->set_var("arp_method", "POST");
				}else{
					if ($q->f("field")=="email"){
						$t->set_var("arp_email_value","email");
						$t->set_var("email_value",$q->f("value"));
						$arp_email_value = $q->f("value");
						$arp_subscription.='<input type="hidden" name="'.$q->f("value").'">';
					}
					if ($q->f("field")=="first_name"){
						$t->set_var("first_name_value","first_name");
						$t->set_var("first_name_noaweber",$q->f("value"));
						$arp_first_name_value = $q->f("value");
						$arp_subscription.='<input type="hidden" name="'.$q->f("value").'">';
					}
					$t->set_var("form_switch","do.signup.php");
					$t->set_var("send_method","POST");
					if ($q->f("field")=="url") $t->set_var("arp_action", $q->f("value"));
					if ($q->f("field")=="method") $t->set_var("arp_method", ($q->f("value") == 1 ? "GET" : "POST"));
				}
					
			}
			if ($switch){
				$t->set_var("arp_subscription", "");
				$t->set_var("arp_fields", $arp_subscription);
			}else{
				$t->set_var("arp_subscription", $arp_subscription);
				$t->set_var("arp_fields", "");
			}
		}else{
			$t->set_var("form_switch","do.signup.php");
			$t->set_var("send_method","POST");
			$t->set_var("arp_fields", "");
			$t->set_var("form2items", "if (validate_form()) document.form1.submit();");
		}
		$query="select * from signup_settings where atsignup='1' order by position asc";
		$q->query($query);
		while ($q->next_record())
		{
			if (get_setting("cut_signup")){
							
				if ($q->f("field") == 'email'){
					if ($switch) $t->set_var("field_name", $arp_email_value);
					else $t->set_var("field_name", "email");
					if ($switch) $t->set_var("email_value", 'email');
					$t->set_var("description", $q->f("description"));
					$t->set_var("field_type", "text");
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					$t->parse("signup_list", "signuplist", true);
					
					if ($q->f("required")==1) $t->set_var("required", "*");
					else $t->set_var("required", "");
				}elseif ($q->f("field") == 'first_name'){
					if ($switch) $t->set_var("field_name", $arp_first_name_value);
					else $t->set_var("field_name", "first_name");
					if ($switch) $t->set_var("first_name_noaweber", 'first_name');
					$t->set_var("description", $q->f("description"));
					$t->set_var("field_type", "text");
					if ($q->f("required")==1) $t->set_var("required", "*");
					else $t->set_var("required", "");
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					$t->parse("signup_list", "signuplist", true);
				}elseif ($q->f("field") == 'country' && $exist_physical>0 && get_setting("ask_country_on_product")!=1) { // country_list_code
				$shiping_country_list.="<select name=\"".$q->f("field")."\" id=\"".$q->f("field")."\" style=\"width: 15em;\">";
				$shiping_country_list.="<option value=\"0\">Choose country</option>";
					$query="SELECT * FROM countries WHERE  id!='0' order by country asc";
					$q2->query($query);
					while ($q2->next_record()) {
					$shiping_country_list.="<option value=\"".$q2->f('id')."\">".$q2->f('country')."</option>";
					}
				$shiping_country_list.="</select>";
				
				$t->set_var("shiping_country_list", "$shiping_country_list");
				$shiping_country_list="";	
				$t->set_var("description_country", $q->f("description").":");	
					if ($q->f("required")==1){
						$validation_string .= "
if (document.form1.".$q->f("field").".value == '0'){
	err += 'No ".$q->f("description").".\\n';
}
							";
						$t->set_var("required_country", "*");
					}else $t->set_var("required_country", "");	
				}
			}else{
				if ($q->f("field")=='password')
				{ 
					$t->set_var("description", $q->f("description"));
					$t->set_var("field_name", $q->f("field"));
					if ($q->f("field")=="password") $t->set_var("field_type", "password");
					else $t->set_var("field_type", "text");
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					if ($q->f("required")==1) $t->set_var("required", "*");
					else $t->set_var("required", "");
					$t->parse("signup_list", "signuplist", true);
					$t->set_var("description", "Confirm password");
					$t->parse("signup_list", "confirmpass", true);
				}
				elseif ($q->f("field")!='country') 
				{
					
					$t->set_var("description", $q->f("description"));
					if ($switch){
						if ($q->f("field") == 'first_name'){
							$t->set_var("field_name", $arp_first_name_value);
							$t->set_var("first_name_noaweber", $q->f("field"));
						}elseif($q->f("field") == 'email'){
							$t->set_var("email_value", $q->f("field"));
							$t->set_var("field_name", $arp_email_value);
						}else{
							$t->set_var("field_name", $q->f("field"));
						}
					}else{
						$t->set_var("field_name", $q->f("field"));
					}
					$t->set_var("field_type", "text");
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					if ($q->f("required")==1){
						$validation_string .= "
if (document.form1.".($switch && $q->f("field") == 'first_name' ? $arp_first_name_value : ($switch && $q->f("field") == 'email' ? $arp_email_value : $q->f("field"))) .".value == ''){
	err  += 'No ".$q->f("description").".\\n';
}
							";
						$t->set_var("required", "*");
					}else $t->set_var("required", "");
					$t->parse("signup_list", "signuplist", true);
				} else { // country_list_code
				$shiping_country_list.="<select name=\"".$q->f("field")."\" id=\"".$q->f("field")."\" style=\"width: 15em;\">";
				$shiping_country_list.="<option value=\"0\">Choose country</option>";
					$query="SELECT * FROM countries WHERE  id!='0' order by country asc";
					$q2->query($query);
					while ($q2->next_record()) {
					$shiping_country_list.="<option value=\"".$q2->f('id')."\">".$q2->f('country')."</option>";
					}
				$shiping_country_list.="</select>";
				
				$t->set_var("shiping_country_list", "$shiping_country_list");
				$shiping_country_list="";	
				$t->set_var("description_country", $q->f("description").":");	
					if ($q->f("required")==1){
						$validation_string .= "
if (document.form1.".$q->f("field").".value == '0'){
	err += 'No ".$q->f("description").".\\n';
}
							";
						$t->set_var("required_country", "*");
					}else $t->set_var("required_country", "");	
					
				}
			}
		}
		$query="select * from signup_settings where atsignup='1' order by position asc";
		$q->query($query);
		while ($q->next_record())
		{
			if (get_setting("cut_signup")){
				if ($q->f("field") == 'email'){
					$t->set_var("field_name", "email");
					$t->set_var("field_type", "text");
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					$t->parse("signup_list_b", "signuplist_b", true);
				}elseif ($q->f("field") == 'first_name'){
					$t->set_var("field_name", "first_name");
					$t->set_var("field_type", "text");
					$t->set_var("chk", '<input name="terms" id="terms" value="" type="hidden" style="display:none">');					
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					$t->parse("signup_list_b", "signuplist_b", true);
				}elseif ($q->f("field") == 'country' && $exist_physical>0 && get_setting("ask_country_on_product")!=1) { // country_list_code
				$shiping_country_list.="<select name=\"".$q->f("field")."\" id=\"".$q->f("field")."\" style=\"width: 15em;\">";
				$shiping_country_list.="<option value=\"0\">Choose country</option>";
					$query="SELECT * FROM countries WHERE  id!='0' order by country asc";
					$q2->query($query);
					while ($q2->next_record()) {
					$shiping_country_list.="<option value=\"".$q2->f('id')."\">".$q2->f('country')."</option>";
					}
				$shiping_country_list.="</select>";
				$t->set_var("shiping_country_list_b", "$shiping_country_list");
				$shiping_country_list="";	
				$t->set_var("description_country_b", $q->f("description").":");	
					if ($q->f("required")==1){
						$t->set_var("required_country_b", "*");
					}else $t->set_var("required_country_b", "");	
				}
				
				if (get_setting("signup_with_code")==1)
					{
						$t->set_var("code_signup1", '<input name="signup_code" size="29" type="hidden">');
					}
					if (get_setting("enable_captcha")==1)
						$t->set_var("captcha1",'<input type="hidden" name="hncaptcha" value=""><input type="hidden" name="public_key" value=""><input type="hidden" name="private_key" value="">');
					else 
						$t->set_var("captcha1",'');
				
			}else{			
				if ($q->f("field")=='password')
				{ 
					$t->set_var("description", $q->f("description"));
					$t->set_var("field_name", $q->f("field"));
					if ($q->f("field")=="password") $t->set_var("field_type", "password");
					else $t->set_var("field_type", "text");
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					if ($q->f("required")==1) $t->set_var("required", "*");
					else $t->set_var("required", "");
					$t->parse("signup_list_b", "signuplist_b", true);
					$t->set_var("description", "Confirm password");
					if (get_setting("show_promo_signup")==1)
						{
							$t->set_var("promo", "Promotion code:</td><td> <input type=text size='29' name=promo>");
						}
					$t->parse("signup_list_b", "confirmpass", true);
				}
				elseif ($q->f("field")!='country') 
				{
					$t->set_var("description", $q->f("description"));
					$t->set_var("field_name", $q->f("field"));
					$t->set_var("field_type", "text");
					$t->set_var("fieldvalue", stripslashes($_GET[$q->f("field")]));
					$t->set_var("chk", '<input name="terms" id="terms" value="" type="hidden" style="display:none">');
					if (get_setting("show_promo_signup")==1)
					{
						$t->set_var("promo1", "Promotion code:</td><td> <input type=text size='29' name=promo>");
					}
					if (get_setting("signup_with_code")==1)
					{
						$t->set_var("code_signup1", '<input name="signup_code" size="29" type="hidden">');
					}
					if (get_setting("enable_captcha")==1)
						$t->set_var("captcha1",'<input type="hidden" name="hncaptcha" value=""><input type="hidden" name="public_key" value=""><input type="hidden" name="private_key" value="">');
					else 
						$t->set_var("captcha1",'');
				
					$t->parse("signup_list_b", "signuplist_b", true);
				} else { // country_list_code
					
				$shiping_country_list.="<select name=\"".$q->f("field")."\" id=\"".$q->f("field")."\" style=\"width: 15em;\">";
				$shiping_country_list.="<option value=\"0\">Choose country</option>";
					$query="SELECT * FROM countries WHERE  id!='0' order by country asc";
					$q2->query($query);
					while ($q2->next_record()) {
					$shiping_country_list.="<option value=\"".$q2->f('id')."\">".$q2->f('country')."</option>";
					}
				$shiping_country_list.="</select>";
				
				$t->set_var("shiping_country_list_b", "$shiping_country_list");	
				$t->set_var("description_country_b", $q->f("description"));	
					if ($q->f("required")==1){
						$t->set_var("required_country_b", "*");
					}else $t->set_var("required_country_b", "");	
				}
			}
		}
		$validation_string .= "
if (emailCheck(document.form1.".($switch ? $arp_email_value : 'email').".value) == false){
	err += 'No Valid email.\\n';
}
if (document.form1.terms.checked != true){				
	err += 'You did not agree with the terms.\\n';
}
		";
$validation_string .= "
if (err != 'The following fields are not correct filled:\\n'){
	alert (err);
	return false;
}
";
$t->set_var("error",$error);
$t->set_var("validation_text",$validation_string);		
		
		$q->query("select product_id from session where session_id='$custom'");
		$q->next_record();
		if ($q->f("product_id"))
			$product_id=$q->f("product_id");
		else die('Product not found');
		$q->query("SELECT * FROM products WHERE signup=1 and id='$product_id'");
		$q->next_record();
		if ($q->f('recurring_auth')){
                $t->set_var("interval_length", $q->f('period_auth'));
                $t->set_var("startDate", date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$q->f('start_auth_subscr'), date("Y"))));
                $t->set_var("totalOccurrences", $q->f('times_auth'));
                $t->set_var("trialOccurrences", $q->f('times_trial_auth'));
                $t->set_var("trialAmount", $q->f('trial_auth_amount'));
                $t->set_var("interval_unit", $q->f('type_auth'));
        }
                $t->set_var("custom", $custom);
                $t->set_var("product", $q->f('nid'));
                $t->set_var("product_nid", $q->f('nid'));
                $t->set_var("product_id", $q->f('id'));
                $t->set_var("product_name", $q->f('display_name'));
                $t->set_var("amount", $q->f('price'));
                if (get_setting('auth_test')) 
                	$t->set_var("test", '<input type="hidden" name="x_test_request" value="TRUE">');
                else $t->set_var("test", '');
                
		//START CYCLER CODE
	if (get_setting('activate_cycler')){
		if ($_COOKIE['cycle']=='')
		{
			$query="select * from cycle WHERE file='signup.php' group by cycle";
			$q->query($query);
			$i=0;
			while ($q->next_record())
			{
				$winner=get_setting("make_winner");
					
				if ( preg_match('/('.$q->f("cycle").')\:(\d+)/',$winner,$match)){
						$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
						$q2->next_record();
						$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
					}
				else{
				$query="select * from cycle where file='signup.php' AND cycle='".$q->f("cycle")."' order by rand() limit 1";
				$q2->query($query);
				$q2->next_record();
				}
				if ($i==0)
				{
					$cookiecycle=$q2->f("cycle").":".$q2->f("id");
					$i=1;
				}
				else
					$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
				$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
			}
			$ar_host=parse_url(get_setting("site_full_url"));
			$host=$ar_host["host"];
			$path=$ar_host["path"];
			$host=str_replace("www","",$host);
			if ($q->nf() != 0)
				$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='signup'");
			setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
		}
		else
		{
			$text=base64_decode($_COOKIE['cycle']);
				$cycle=explode(":", $text);
				$query="select text,file from cycle where id='".$cycle[count($cycle)-1]."'";
				$q->query($query);
				$q->next_record();
				if ($q->f('file') == 'index.php'){
					$cycle_arr_first = explode("-",$cycle[0]);
					$q2->query("UPDATE cycle_stats SET used=1 WHERE id='".$cycle_arr_first[0]."'");
				}
				if ($q->f('file') != 'signup.php'){
					
					$query="select * from cycle WHERE file='signup.php' group by cycle";
					$q->query($query);
					$i=0;
					while ($q->next_record())
					{
					$winner=get_setting("make_winner");
					if ( preg_match('/('.$q->f("cycle").')\:(\d+)/',$winner,$match)){
						$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
						$q2->next_record();
						$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
					}
					else{
						$query="select * from cycle where file='signup.php' AND cycle='".$q->f("cycle")."' order by rand() limit 1";
						$q2->query($query);
						$q2->next_record();
						if ($i==0)
						{
							$cookiecycle=$q2->f("cycle").":".$q2->f("id");
							$i=1;
						}
						else
							$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
						$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
					}
					}
					$ar_host=parse_url(get_setting("site_full_url"));
					$host=$ar_host["host"];
					$path=$ar_host["path"];
					$host=str_replace("www","",$host);
					if ($q->nf() != 0)
						$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='signup'");
					setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
							
				} else{
					$query="select id,cycle,text from cycle WHERE file='signup.php' group by cycle";
					$q3->query($query);
				
					while ($q3->next_record())
					{
						$winner=get_setting("make_winner");
						
						if ( preg_match('/('.$q3->f("cycle").')\:(\d+)/',$winner,$match)){
							$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
							$q2->next_record();
							$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
						}
					}
					$cycle_name = explode("-",$cycle[0]);
					$t->set_var("cycle_".$cycle_name[1], $q->f("text"));
					for ($j=2 ; $j <= count($cycle)-1 ; $j++){
						$query="select text,file,cycle from cycle where id='$cycle[$j]'";
						$q3->query($query);
						$q3->next_record();
						$t->set_var("cycle_".$q3->f("cycle"), $q3->f("text"));
					}
				}
		}
	}
	//END CYCLER CODE
include("inc.bottom.php");
?>