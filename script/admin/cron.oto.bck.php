<?php
	include ("inc.all.php");
$q2=new Cdb;
	if (get_setting("otobckeusescript")==1 && get_setting("otobckeactive")==1)
	{
	
		$membership_id=get_setting("default_free");
			$now=time();
			$afterxdays=get_setting("otobckedays");
			$membership_id=get_setting("default_free");
			if (get_setting("otobckem")==1)
			$q->query("select * from members where s_date + '".($afterxdays*3600*24)."'< $now and oto_email=0 and membership_id='$membership_id'");
			else
			$q->query("select * from members where s_date + '".($afterxdays*3600*24)."'< $now and oto_email=0");
			while ($q->next_record())
			{
				$subject=get_setting("otobckes");
				$body=get_setting("otobckeb");
				$query="select * from tags";
				$q2->query($query);
				while($q2->next_record())
				{
					$subject=str_replace("{".$q2->f("field")."}", $q->f($q2->f(field)), $subject);
					$body=str_replace("{".$q2->f("field")."}", $q->f($q2->f(field)), $body);
					$link=get_setting("site_full_url")."login.oto.php";
					$body=str_replace("{special_oto_link}", $link, $body);
					$body=str_replace("[sitename]",get_setting("site_name"),$body);
				}
				mail($q->f("email"), $subject, $body, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
				$q2->query("update members set oto_email=1 where id='".$q->f("id")."'");
			}
	}
	else
	{
		die();
	}
?>