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
	get_logged_info(); //member area init...
	$user_id = $q->f("id");
	$q2 = new CDb();
	$q3 = new CDb();
	$query="select * from members where id='$id'";
	$q->query($query);
	$q->next_record();
	
	if ($q->f("public_profile")!=1) 
	{
		die("This profile is not public.");
	}
	$t->set_file("content", "member.area.other.profile.html");
	$q2->query("SELECT membership_id FROM members a, settings b WHERE a.id='".$user_id."' AND b.name='site_overview' AND FIND_IN_SET(a.membership_id,b.value)");
	$q2->next_record();
	
	if ($q2->f("membership_id"))
	{
		$t->set_var("stats", "<a href=\"member.area.stats.php\">View Stats</a>");
		
	}
	else $t->set_var("stats", "");
	
	if ($q->f("p_first_name")==1) { $t->set_var("first_name", $q->f("first_name")); $name.= $q->f("first_name"); }
	else $t->set_var("first_name","");
	if ($q->f("p_last_name")==1) $t->set_var("last_name", $q->f("last_name"));
	else $t->set_var("last_name","");
	 $t->set_var("name", $name);
	 $t->set_var("id", $q->f("id"));
	if ($q->f("p_address")==1) $t->set_var("address", $q->f("address"));
	else $t->set_var("address","");
	if ($q->f("p_city")==1) $t->set_var("city", $q->f("city"));
	else $t->set_var("city","");
	if ($q->f("p_zip")==1) $t->set_var("zip", $q->f("zip"));
	else $t->set_var("zip","");
	if ($q->f("p_state")==1) $t->set_var("state", $q->f("state"));
	else $t->set_var("state","");
	if ($q->f("p_country")==1) {
		$q3->query("SELECT country FROM countries WHERE id='".$q->f("country")."'");
		$q3->next_record();
		$t->set_var("country", $q3->f("country")); }
	else $t->set_var("country","");
	if ($q->f("p_home_phone")==1) $t->set_var("home_phone", $q->f("home_phone"));
	else $t->set_var("home_phone","");
	if ($q->f("p_work_phone")==1) $t->set_var("work_phone", $q->f("work_phone"));
	else $t->set_var("work_phone","");
	if ($q->f("p_cell_phone")==1) $t->set_var("cell_phone", $q->f("cell_phone"));
	else $t->set_var("cell_phone","");
	if ($q->f("p_email")==1) $t->set_var("email", $q->f("email"));
	else $t->set_var("email","");
	if ($q->f("p_msn_id")==1) $t->set_var("msn_id", $q->f("msn_id"));
	else $t->set_var("msn_id","");
	if ($q->f("p_yahoo_id")==1) $t->set_var("yahoo_id", $q->f("yahoo_id"));
	else $t->set_var("yahoo_id","");
	if ($q->f("p_icq_id")==1) $t->set_var("icq_id", $q->f("icq_id"));
	else $t->set_var("icq_id","");
	if ($q->f("p_url1")==1) $t->set_var("url1", $q->f("url1"));
	else $t->set_var("url1","");
	if ($q->f("p_url2")==1) $t->set_var("url2", $q->f("url2"));
	else $t->set_var("url2","");
	if ($q->f("p_url3")==1) $t->set_var("url3", $q->f("url3"));
	else $t->set_var("url3","");
$field_list="";	
$q2->query("SELECT * FROM signup_settings WHERE new=1 ");
while ($q2->next_record()){
	
	$query="SHOW COLUMNS FROM members";
$q3->query($query );
while($q3->next_record()) {
	$found=0;
if ($q3->f("Field")=="p_".$q2->f("field")){	
		$t->set_var("descr",$q2->f("description").":");
		$t->set_var("field",$q->f($q2->f("field")));
		FFileRead("./templates/member.area.other.profile.item.html",$w);
		$w=str_replace("{descr}",$q2->f("description").":",$w);
		$w=str_replace("{field}",$q->f($q2->f("field")),$w);
		
		$t->parse("list",$w,true);
		$field_list.=$w;
	}
}
}
$t->set_var("list",$field_list); 
include("inc.bottom.php");
?>