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

 
	include ('inc.all.php');
	set_time_limit(0);
	$q2=new CDB;
	$q3=new CDB;
	$q4=new CDB;
	$query="select * from autoresponders where sent=0 and days!=0";
	$q->query($query);
	if ($q->nf()==0) die();
	$now=time();
	while ($q->next_record())
	{
		$k=0; 
		$downlimit=mktime(0,0,0, date("n", $now), date("j", $now)-$q->f("days"), date("Y", $now));
		$uplimit=mktime(23,59,59, date("n", $now), date("j", $now)-$q->f("days"), date("Y", $now));
		$query="select title, field from tags";
		$q2->query($query);
		if ($q->f("membership")==0)
			$query="select * from members where s_date >$downlimit and s_date < $uplimit and unsubscribed=0";
		else $query="select * from members where membership_id='".$q->f("membership")."' and s_date >$downlimit and s_date < $uplimit and unsubscribed=0";
		if ($q->f("filter")!="<b>None</b>")
		$query.=" and ".stripslashes($q->f("filter"));
		$query.=" order by id";
		$q2->query($query);
		$body=$q->f("header").$q->f("body").$q->f("footer");
		$subject=$q->f("subject");
		while ($q2->next_record())
		{
			$bodyx=$body;
			$subjectx=$subject;
			ReplaceTags($subjectx, $q2->f("id"), $subjecty);
			ReplaceTags($bodyx, $q2->f("id"), $bodyy);
			$bodyy=str_replace("[[affiliate_link]]", get_aff_link($q2->f("id")), $bodyy);
			if ($q->f("sendby")==1)
			{
			$unsub_link=get_setting("site_full_url")."unsub/unsub.php?code=".md5(get_setting("secret_string")."-".$q2->f("id"));
			$bodyy=str_replace("[[unsub]]", $unsub_link, $bodyy);
			$from=$q->f("from_email");
			
			$query="SELECT * FROM pending WHERE autoresponder_id='".$q->f("id")."' AND to_email='".$q2->f("email")."'";
			$q4->query($query);
			$q4->next_record();
			if ($q4->nf()<1) {
					$query="insert into pending (autoresponder_id, to_email, body, subject, from_email) values	('".$q->f("id")."', '".$q2->f("email")."', '".addslashes($bodyy)."', '".addslashes($subjecty)."', '$from')";
					$q3->query($query);
					$k++;
				}
			}
			else if ($q->f("sendby")==2)
			{
				$k++;
				$bodyy=str_replace("[[unsub]]", "", $bodyy);
				$query="SELECT * FROM messages WHERE member_id='".$q2->f("id")."' AND body='$bodyy'";
				$q4->query($query);
				$q4->next_record();
				if ($q4->nf()<1) {
				$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('".$q2->f("id")."', '1', '$subjecty', '$bodyy', NOW(), NOW())";
				$q3->query($query);
				}
			}
			else if ($q->f("sendby")==3)
			{
				$unsub_link=get_setting("site_full_url")."unsub/unsub.php?code=".md5(get_setting("secret_string")."-".$q2->f("id"));
				$bodyy=str_replace("[[unsub]]", $unsub_link, $bodyy);
	
				$from=$q->f("from_email");
			$query="SELECT * FROM pending WHERE autoresponder_id='".$q->f("id")."' AND to_email='".$q2->f("email")."'";
			$q4->query($query);
			$q4->next_record();
			if ($q4->nf()<1) {
	
				$query="insert into pending (autoresponder_id, to_email, body, subject, from_email) values	('".$q->f("id")."', '".$q2->f("email")."', '".addslashes($bodyy)."', '".addslashes($subjecty)."', '$from')";
	
				$q3->query($query);
	
				$k++;
			}
				$bodyy=str_replace("[[unsub]]", "", $bodyy);
				$query="SELECT * FROM messages WHERE member_id='".$q2->f("id")."' AND body='$bodyy'";
				$q4->query($query);
				$q4->next_record();
				if ($q4->nf()<1) {
				$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('".$q2->f("id")."', '1', '$subjecty', '$bodyy', NOW(), NOW())";
				$q3->query($query);
				}
			}
		}
		$query="update autoresponders set count=count + $k where id='".$q->f("id")."'";
		$q3->query($query);
	}
?>