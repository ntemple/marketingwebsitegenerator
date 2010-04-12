<?php 
include("inc.top.php");
$q2=new CDB;
$q3=new CDB;
$q4=new CDB;
function do_check($name)
{
	global $t, $q;
	if ($q->f($name)==1)
	$t->set_var($name,"checked");
	else
	$t->set_var($name,"");
}
get_logged_info();
$q2=new CDB;
$query="SELECT id FROM menus WHERE link='member.area.profile.php'";
$q2->query($query);
$q2->next_record();
$query="SELECT membership_id FROM menu_permissions WHERE menu_item='".$q2->f("id")."'";
$q2->query($query);
while ($q2->next_record()) {
	$permissions[]=$q2->f("membership_id");
}
if (count($permissions)>0) {
	$error='<center><font color="red"><b>You do not have access to this area!<br><br>Upgrade your membership level!</b></font></center>';
	foreach ($permissions as $value) {
		if ($value==$q->f("membership_id")) {
			$error='';
			break;
		}
	}
	if ($error!="") {
		die("$error");
	}
}
$member_id=$q->f("id");
$membership_id=$q->f("membership_id");
replace_tags_t($member_id, $t);
if (get_setting("enable_profile_directory")!=1)
{
	$t->set_file("content", "member.area.profile.no.directory.html");
	$t->set_file("fieldlist", "member.area.profile.no.directory.row.html");
}
else
{
	$t->set_file("content", "member.area.profile.html");
	$t->set_file("fieldlist", "member.area.profile.row.html");
}
$t->set_var("id", $q->f("id"));
$query="select * from signup_settings where membersarea=1 order by position asc";
$q2->query($query);
while ($q2->next_record())
{
	if ($q2->f("field")!='password' && $q2->f("field")!='credits' && $q2->f("field")!='country' && $q2->f("field") != 'jv_customsales' && $q2->f("field") != 'jv_customdownload'){
		$gasit_var = 0;
		$t->set_var("field_type", "<input type=\"text\" size =\"29\" name=\"{field}\" value=\"{fieldvalue}\">{asterisk}");
		$t->set_var("description", $q2->f("description"));
		$t->set_var("field", $q2->f("field"));
		$gasit = "";
		$q3->query("SHOW COLUMNS FROM members");
		while ($q3->next_record()){
			preg_match("'^p_.*'",$q3->f("Field"),$match);
			$match[0] ? $gasit .= $match[0]."," : $gasit.= "";
		}
		$pattern = "'".$q2->f("field").",'";
		preg_match($pattern,$gasit,$match);
		$select = "";
		if ($match[0]){ $select = ", p_".$q2->f("field"); $gasit_var = 1; }
			
		$query="select ".$q2->f("field").$select." from members where id='".$q->f("id")."'";
		$q3->query($query);
		$q3->next_record();
		$t->set_var("fieldvalue", $q3->f($q2->f("field")));
			
		if ($q2->f("required")){
			$t->set_var("asterisk", "*");
		}else $t->set_var("asterisk", "");
		if (get_setting("enable_profile_directory")==1)
		if ($gasit_var){
			if ($q3->f("p_".$q2->f("field"))==1)
			{
				$t->set_var("checkbox", "<input type='checkbox' name='"."p_".$q2->f("field")."' id='"."p_".$q2->f("field")."' checked>");
			}else
			$t->set_var("checkbox", "<input type='checkbox' name='"."p_".$q2->f("field")."' id='"."p_".$q2->f("field")."'>");
		}else{
			$t->set_var("checkbox", "");
		}
		$t->parse("field_list", "fieldlist", true);
	} elseif ($q2->f("field")=='country') {
		$t->set_var("description", $q2->f("description"));
		$shiping_country_list.="<select name=\"".$q2->f("field")."\" id=\"".$q2->f("field")."\" style=\"width: 15em;\">";
		$shiping_country_list.="<option value=\"0\">Choose country</option>";
		$query="SELECT * FROM countries WHERE  id!='0' order by country asc";
		$q4->query($query);
		while ($q4->next_record()) {
			if ($q->f("country")==$q4->f('id')) {
				$shiping_country_list.="<option selected value=\"".$q4->f('id')."\">".$q4->f('country')."</option>";
			} else {
				$shiping_country_list.="<option value=\"".$q4->f('id')."\">".$q4->f('country')."</option>";
			}
		}
		$shiping_country_list.="</select>";
		$query="select ".$q2->f("field").$select." from members where id='".$q->f("id")."'";
		$q3->query($query);
		$q3->next_record();
		$gasit_var = 0;
		$t->set_var("field_type", "<input type=\"text\" size =\"29\" name=\"{field}\" value=\"{fieldvalue}\">{asterisk}");
		$t->set_var("description", $q2->f("description"));
		$t->set_var("field", $q2->f("field"));
		$gasit = "";
		$q3->query("SHOW COLUMNS FROM members");
		while ($q3->next_record()){
			preg_match("'^p_.*'",$q3->f("Field"),$match);
			$match[0] ? $gasit .= $match[0]."," : $gasit.= "";
		}
		$pattern = "'".$q2->f("field").",'";
		preg_match($pattern,$gasit,$match);
		$select = "";
		if ($match[0]){ $select = ", p_".$q2->f("field"); $gasit_var = 1; }
			
		$query="select ".$q2->f("field").$select." from members where id='".$q->f("id")."'";
		$q3->query($query);
		$q3->next_record();
		$t->set_var("fieldvalue", $q3->f($q2->f("field")));
		if ($q2->f("required")){
			$t->set_var("asterisk", "*");
		}else $t->set_var("asterisk", "");
		$t->set_var("field_type", "$shiping_country_list {asterisk}");
		if (get_setting("enable_profile_directory")==1)
		if ($gasit_var){
			if ($q3->f("p_".$q2->f("field"))==1)
			{
				$t->set_var("checkbox", "<input type='checkbox' name='"."p_".$q2->f("field")."' id='"."p_".$q2->f("field")."' checked>");
			}else
			$t->set_var("checkbox", "<input type='checkbox' name='"."p_".$q2->f("field")."' id='"."p_".$q2->f("field")."'>");
		}else{
			$t->set_var("checkbox", "");
		}
		$t->parse("field_list", "fieldlist", true);
	} elseif($q2->f("field") == 'jv_customsales' && get_setting("jv_custom")) {
		$jv_custom_memberships_arr = explode(",",get_setting("jv_custom_memberships"));
		if (array_search($membership_id,$jv_custom_memberships_arr) !== false){
			$query = "select ".$q2->f("field").$select." from members where id='".$member_id."'";
			$q3->query($query);
			$q3->next_record();
			$t->set_var("field_type", "<textarea name=\"{field}\" cols='25' rows='10'>".str_replace("<", "&lt;", $q3->f($q2->f("field")))."</textarea>");
			$t->set_var("description", $q2->f("description"));
	
			$t->set_var("field", $q2->f("field"));
			$t->parse("field_list", "fieldlist", true);
		}
	} elseif($q2->f("field") == 'jv_customdownload' && get_setting("jv_custom")) {
		$jv_custom_memberships_arr = explode(",",get_setting("jv_custom_memberships"));
		if (array_search($membership_id,$jv_custom_memberships_arr) !== false){
			$query = "select ".$q2->f("field").$select." from members where id='".$member_id."'";
			$q3->query($query);
			$q3->next_record();
			$t->set_var("field_type", "<textarea name=\"{field}\" cols='25' rows='10'>".str_replace("<", "&lt;", $q3->f($q2->f("field")))."</textarea>");
			$t->set_var("description", $q2->f("description"));
			$t->set_var("field", $q2->f("field"));
			$t->parse("field_list", "fieldlist", true);
		}
	}
}
if ($q->f("public_profile")==1) $t->set_var("public_profile", "checked");
else $t->set_var("public_profile", "");
$aff_link=get_aff_link($q->f("id"));
$t->set_var("aff_link", $aff_link);
if (get_setting("show_promo_profile")==1)
{
	$t->set_file("promof", "redeem.promo.html");
	$t->parse("promo", "promof");
}
if (get_setting("view_downline")==1)
{
	$t->set_var("downline", "<a href=\"member.area.downline.php\">View Downline</a>");
		
}
else $t->set_var("downline", "");
if (get_setting("delete_acount")==1)
{
	$t->set_var("del_account", "<a href=\"do.delete.user.php\" onClick='return confirm(\"Are you sure you want to delete your account?\");'>Delete Your Account</a>");
		
}
else $t->set_var("del_account", "");
$q3->query("SELECT membership_id FROM members a, settings b WHERE a.id='".$q->f("id")."' AND b.name='view_stats_chk' AND FIND_IN_SET(a.membership_id,b.value)");
$q3->next_record();
if ($q3->f("membership_id") && get_setting("view_stats")==1)
{
	$t->set_var("stats", "<a href=\"member.area.stats.php\">View Stats</a>");
		
}else $t->set_var("stats", "");
if ($_GET['err'] == "email"){
	$t->set_var("error", "<tr><td style='color:red'><b>The email you submited is invalid</b></td></tr>");
		
}elseif ($_GET['err'] == "required_fields"){
	$t->set_var("error", "<tr><td style='color:red'><b>The fields marked with * are mandatory fields</b></td></tr>");
		
}else $t->set_var("error", "");
include("inc.bottom.php");
if ($nocountry) {
	echo "<script> alert ('Please choose your country'); document.form1.country.focus(); </script>";
}
?>