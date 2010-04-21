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


if (get_setting("ban_active") == 1 && get_setting("ban_kind") == 1) {
	$ip = $REMOTE_ADDR;
	$query = "select * from ban_rules where ban='ip' and rule='$ip'";
	$q->query($query);
	if ($q->nf() != 0) die("You are not allowed to view this site");
}
//race
$q2 = new CDb();
$q3 = new CDb();
$q->query("SELECT a.id, end_type, date_end, ref_end, MAX(level1_ref) AS max FROM race_details a, race_stats b WHERE a.enable=1 AND race_id=a.id GROUP BY a.id");
$q->next_record();
if ($q->f("end_type") == 1) {
	$azi = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	$end_date = mktime(0, 0, 0, substr($q->f("date_end"), 5, 2), substr($q->f("date_end"), 8, 2), substr($q->f("date_end"), 0, 4));
	$dif = $end_date - $azi;
	if ($dif < 0) {
		$q->query("UPDATE race_details SET enable=0 WHERE id='".$q->f("id")."'");
	}
} else {
	if ($q->f("max") == $q->f("ref_end")) {
		$q->query("UPDATE race_details SET enable=0 WHERE id='".$q->f("id")."'");
	}
}
//end race
$t->set_var("sitename", SITENAME);
if (isset($sess_id)) {
	if (get_setting("verticalmenumembers") == 1)
	$t->set_file("main", "main.vertical.html");
	else
	$t->set_file("main", "main.html");
	$q2 = new CDB;
	$query = "select membership_id from members where mdid='$sess_id'";
	$q2->query($query);
	$q2->next_record();
	$membership_id = $q2->f("membership_id");
	$t->set_var("menu", stripslashes(generate_members_menu($membership_id)));
	get_logged_info();
	$t->set_var("inbox", get_unread_inbox($q->f("id")));
	$user_id = $q->f("id");
	$member_id = $q->f("id");
} else {
	if (get_setting("dual_templates") == 1 ) {
		if (get_setting("verticalmenumain") == 1)
		$t->set_file("main", "main.vertical.not.logged.in.html");
		else
		$t->set_file("main", "main.not.logged.in.html");
		$t->set_var("menu", stripslashes(generate_main_menu()));
	} else {
		if (get_setting("verticalmenumain") == 1)
		$t->set_file("main", "main.vertical.html");
		else
		$t->set_file("main", "main.html");
		$t->set_var("menu", stripslashes(generate_main_menu()));
	}
}
if (get_setting("enable_bm_aff_link") != 0) {
	if (get_setting("enable_bm_aff_link") == 1)
	$t->set_var("bm_aff_link", "Site powered by <a href='".get_setting("bm_aff_link")."' target=_blank>MarketingWebsiteGenerator.com</a>");
	if (get_setting("enable_bm_aff_link") == 1 && $sess_id)
	$t->set_var("bm_aff_link", "Site powered by <a href='".get_setting("bm_aff_link")."' target=_blank>MarketingWebsiteGenerator.com</a>");
	if (get_setting("enable_bm_aff_link") == 1 && !$sess_id)
	$t->set_var("bm_aff_link", "Site powered by <a href='".get_setting("bm_aff_link")."' target=_blank>MarketingWebsiteGenerator.com</a>");
}else
$t->set_var("bm_aff_link", "");
$ocontent = $t->parse("page", "content");
if (isset($sess_id)) {
	$q3->query("SELECT aff FROM members WHERE id='".$member_id."'");
	$q3->next_record();
	$affiliate_id = $q3->f('aff');
	//custom member download page
	if (get_setting("jv_custom")){
		$q3->query("SELECT membership_id, first_name, id, jv_customdownload FROM members WHERE id='".$affiliate_id."'");
		$q3->next_record();
		$jv_custom_memberships_arr = explode(",",get_setting("jv_custom_memberships"));
		if (array_search($q3->f("membership_id"),$jv_custom_memberships_arr) !== false){
			$ocontent = str_replace("{aff_id}",$q3->f("id"),$ocontent);
			$ocontent = str_replace("{aff_first_name}",$q3->f("first_name"),$ocontent);
			$search = array('/<\?((?!\?>).)*\?>/s'); 
			$ocontent = str_replace("{jv_customdownload}",preg_replace($search, '', $q3->f("jv_customdownload")),$ocontent);
		}
	}
}else $affiliate_id = 0;
// custom member sales page
if (get_setting("jv_custom")){
	$q3->query("SELECT membership_id, first_name, id, jv_customsales FROM members WHERE id='".($affiliate_id ? $affiliate_id : $_COOKIE['aff'])."'");
	$q3->next_record();
	$jv_custom_memberships_arr = explode(",",get_setting("jv_custom_memberships"));
	if (array_search($q3->f("membership_id"),$jv_custom_memberships_arr) !== false){
		$ocontent = str_replace("{aff_id}",$q3->f("id"),$ocontent);
		$ocontent = str_replace("{aff_first_name}",$q3->f("first_name"),$ocontent);
		$search = array('/<\?((?!\?>).)*\?>/s');
		$ocontent = str_replace("{jv_customsales}",preg_replace($search, '', $q3->f("jv_customsales")),$ocontent);
	}
}
$q2->query("SELECT nid, id FROM products");
while ($q2->next_record()) {
	$occ_buttons = explode("{".$q2->f('nid')."}", "".$ocontent."");
	if (count($occ_buttons) > 1) {
		$i = 0;
		while ($i < (count($occ_buttons))-1) {
			$rez_button .= $occ_buttons[$i].get_pay_buttons($member_id, $q2->f('id'), ($affiliate_id ? $affiliate_id : $_COOKIE['aff']), new_sess_id(), 0, $i);
			$i++;
		}
		$rez_button .= $occ_buttons[$i];
	} else {
		$rez_button = $occ_buttons[0];
	}
	$ocontent = $rez_button;
	$rez_button = "";
}
$t->set_var("content", $ocontent);
$q->query("SELECT value,description FROM settings WHERE name='keywords'");
$q->next_record();
$keywords_arr = explode(",", $q->f("value"));
$i = 0;
$j = 0;
foreach ($keywords_arr as $keyword) {
	$word_arr = explode(" ", $keyword);
	if ($i > 8) break;
	$j++;
	foreach ($word_arr as $word) {
		$i++;
	}
}
if ($i > 8) $j--;
$key_str = "";
for ($i = 0; $i < $j; $i++) {
	$key_str .= $keywords_arr[$i].",";
}
$key_str = substr($key_str, 0, -1);
$t->set_var("keywords_title", $key_str);
$t->set_var("keywords", $q->f("value"));
$q->query("SELECT value,description FROM settings WHERE name='meta-description'");
$q->next_record();
if ($q->f("description") == "from html") {
	FFileRead("templates/homepage.html", $contents);
	$body_inceput = strpos($contents, "<body>");
	$body_sfarsit = strpos($contents, "</body>");
	if ($body_inceput == false) {
		$descr = $contents;
	} else {
		$descr = substr($contents, $body_inceput, $body_sfarsit);
	}
	$what = array("'<body>'", "'</body>'", "'\n'");
	$with = array("", "", " ");
	$descr = preg_replace($what, $with, $descr);
	preg_match_all("'\n'", $descr, $match);
	foreach ($match[0] as $bla) {
		$descr = str_replace("\n", " ", $descr);
	}
	$descr = strip_tags($descr);
	$descr = substr($descr, 0, 255);
	if (strlen($descr) == 255) {
		$last_space = strrchr($descr, " ");
		$descr = substr($descr, 0, -(strlen($descr) - $last_space));
	}
} else {
	$descr = $q->f("value");
}
$t->set_var("description", $descr);
if (isset($sess_id))
replace_tags_t($user_id, $t);
//twitter
if (isset($sess_id) && get_setting("twitter"))
{
	get_logged_info();
	
	$url=get_aff_link($member_id);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://tinyurl.com/api-create.php?url=".$url);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if( ini_get('safe_mode') ){	
	}else curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	$output = curl_exec($ch);
	curl_close($ch);
	$q->query("SELECT * FROM twitter");
	$twitter_array = "<script>var tw=new Array();";
	$i=0;
	while ($q->next_record()){
		$i++;
		$twitter_array .= "tw[$i]= '".str_replace("{aff_tiny_url}",$output,($q->f("tweet")))."';
		";
	}
	$twitter_array .= "	var max_tweet=".$q->nf().";
	function send_tweet()
	{
		randomnumber=Math.floor(Math.random()*max_tweet);
		window.open('http://twitter.com/home?&status='+tw[randomnumber+1],'tweet_window','')
	}
	function disableLinksByElement(el) {
	  if (document.getElementById && document.getElementsByTagName) {
	    var anchors = el.getElementsByTagName('a');
	    for (var i=0, end=anchors.length; i<end; i++) {
	      anchors[i].href = 'javascript:void()';
	    }
	  }
	}
	</script>";
	$twitter_html = "<div id='twitter' onclick='disableLinksByElement(this);send_tweet();' style='cursor:pointer;'>".get_setting("twitter_html")."</div>";
	$t->set_var("aff_twitter_link", $twitter_array.$twitter_html);
}

// MWG
// $t->pparse("out", "main");
$mwg = MWG::getInstance();
$mwg->end($t);
