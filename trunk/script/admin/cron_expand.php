<?php 
	include("inc.all.php");
	set_time_limit(0);
	$q3=new Cdb;
	$q2=new CDb;
	$query="select * from autoresponders where sent=0 and days=0";
	$q->query($query);
	if ($q->nf()==0) die();
	$k=0;
	while ($q->next_record()) {
		$query="update autoresponders set sent=1 where id='".$q->f("id")."'";
	 	$q3->query($query);
	 	$query="select title, field from tags";
		$q2->query($query);
		if ($q->f("membership")==0)
			$query="select * from members where unsubscribed=0";
		else $query="select * from members where membership_id='".$q->f("membership")."' and unsubscribed=0";
		if ($q->f("filter")!="<b>None</b>")
		$query.=" and ".stripslashes($q->f("filter"));
		$query.=" order by id";
		$q2->query($query);
		$k=$q2->nf();
		
		$query="update autoresponders set count=$k where id='".$q->f("id")."'";
		
		$q3->query($query);
		
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
			$query="insert into pending (autoresponder_id, to_email, body, subject, from_email) values	('".$q->f("id")."', '".$q2->f("email")."', '".addslashes($bodyy)."', '".addslashes($subjecty)."', '$from')";
			$q3->query($query);
			$k++;
			}
			else if ($q->f("sendby")==2)
			{
				$k++;
				$bodyy=str_replace("[[unsub]]", "", $bodyy);
				$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('".$q2->f("id")."', '1', '".addslashes($subjecty)."', '".addslashes($bodyy)."', NOW(), NOW())";
				$q3->query($query);
			}
			else if ($q->f("sendby")==3)
			{
				$unsub_link=get_setting("site_full_url")."unsub/unsub.php?code=".md5(get_setting("secret_string")."-".$q2->f("id"));
				$bodyy=str_replace("[[unsub]]", $unsub_link, $bodyy);
	
				$from=$q->f("from_email");
	
				$query="insert into pending (autoresponder_id, to_email, body, subject, from_email) values	('".$q->f("id")."', '".$q2->f("email")."', '".addslashes($bodyy)."', '".addslashes($subjecty)."', '$from')";
	
				$q3->query($query);
	
				$k++;
				
				$bodyy=str_replace("[[unsub]]", "", $bodyy);
				$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('".$q2->f("id")."', '1', '".addslashes($subjecty)."', '".addslashes($bodyy)."', NOW(), NOW())";
				$q3->query($query);
			}
		}
	}
?>
