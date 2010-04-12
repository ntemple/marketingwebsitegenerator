<?php 
	include("inc.top.php");
	
	if (isset($page)) {$membership_search_url.=$page;} else {$membership_search_url.="1";}
	
	if (isset($search)) {$membership_search_url.="&search=$search";}
	
	if (isset($criteria)) {$membership_search_url.="&criteria=$criteria";}
	
	$query="select * from membership where active=1";
	$q->query($query);
	while ($q->next_record())
	{
		if (isset($membership_search_hide[$q->f("id")])) {
			$membership_search_url.="&membership_search_hide[".$q->f("id")."]=".$q->f("id");
		}
	}
	
	if (isset($start) && $start!="") {$membership_search_url.="&start=$start&joined=1&from_change_joined=1";}
	
	if (isset($end) && $end!="") {$membership_search_url.="&end=$end";}
	
	if (isset($check)){
	if ($action=="delete")
	{
		foreach ($check as $x => $value)
		{	
			$query="delete from members where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="activate")
	{
		foreach ($check as $x => $value)
		{	
			$query="update members set active='1' where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="suspend")
		{
			foreach ($check as $x => $value)
			{	
				$query="update members set suspended='1' where id='$x'";
				$q->query($query);
			}
		header("location:members.php?page=$membership_search_url");
		exit;
		}
	if ($action=="unsuspend")
		{
			foreach ($check as $x => $value)
			{	
				$query="update members set suspended='0' where id='$x'";
				$q->query($query);
			}
		header("location:members.php?page=$membership_search_url");
		exit;
		}
	if ($action=="deactivate")
	{
		foreach ($check as $x => $value)
		{	
			$query="update members set active='0' where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="edit")
	{
		
		foreach ($check as $x => $value)
		{	
			$id=$x;
			 break;
		}
			$t->set_file("content", "admin.edit.member.html");
			$t->set_file("membershiplist", "admin.membership.select.html");
			
			$query="select * from members where id='$x'";
			$q->query($query);
			$q->next_record();
			$membership_sel=$q->f("membership_id");
			function do_check($name)
			{
				global $t, $q;
				if ($q->f($name)==1)
					$t->set_var($name,"checked");
				else
					$t->set_var($name,"");
			}
			
			$t->set_var("id", $q->f("id"));
			$t->set_var("member_id", $q->f("id"));
			$t->set_var("username", $q->f("username"));
			$t->set_var("first_name", $q->f("first_name"));
			$t->set_var("password", $q->f("password"));
			$t->set_var("last_name", $q->f("last_name"));
			$t->set_var("email", $q->f("email"));
			$t->set_var("address", $q->f("address"));
			$t->set_var("city", $q->f("city"));
			$t->set_var("state", $q->f("state"));
			$t->set_var("zip", $q->f("zip"));
			$t->set_var("country", $q->f("country"));
			$t->set_var("home_phone", $q->f("home_phone"));
			$t->set_var("work_phone", $q->f("work_phone"));
			$t->set_var("cell_phone", $q->f("cell_phone"));
			$t->set_var("yahoo_id", $q->f("yahoo_id"));
			$t->set_var("msn_id", $q->f("msn_id"));
			$t->set_var("icq_id", $q->f("icq_id"));
			$t->set_var("ssn", $q->f("ssn"));
			$t->set_var("paypal_email", $q->f("paypal_email"));
			$t->set_var("stormpay_email", $q->f("stormpay_email"));
			$t->set_var("url1", $q->f("url1"));
			$t->set_var("url2", $q->f("url2"));
			$t->set_var("url3", $q->f("url3"));
			$t->set_var("membership_search_url", urlencode($membership_search_url));
			
			do_check("p_id");
			do_check("p_first_name");
			do_check("p_last_name");
			do_check("p_email");
			do_check("p_address");
			do_check("p_city");
			do_check("p_state");
			do_check("p_zip");
			do_check("p_country");
			do_check("p_city");
			do_check("p_home_phone");
			do_check("p_work_phone");
			do_check("p_cell_phone");
			do_check("p_yahoo_id");
			do_check("p_msn_id");
			do_check("p_icq_id");
			do_check("p_ssn");
			do_check("p_paypal_email");
			do_check("p_stormpay_email");
			do_check("p_url1");
			do_check("p_url2");
			do_check("p_url3");
			do_check("public_profile");
		
			$query="select * from membership";
			$q->query($query);
			while ($q->next_record())
			{
				$t->set_var("membership_id", $q->f("id"));
				
				if ($q->f("id") == $membership_sel) $t->set_var("membership_selected","selected");
					else $t->set_var("membership_selected","");
				$t->set_var("membership_name", $q->f("name"));
				$t->parse("membership_list", "membershiplist", true);
			}
		
	}
	if ($action=="jv1")
	{
		foreach ($check as $x => $value)
		{	
			$query="update members set jv=1 where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="jv2")
	{
		foreach ($check as $x => $value)
		{	
			$query="update members set jv=2 where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="jv3")
	{
		foreach ($check as $x => $value)
		{	
			$query="update members set jv=0 where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="oto1")
	{
		foreach ($check as $x => $value)
		{	
			$query="update members set oto1=1 where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="oto2")
	{
		foreach ($check as $x => $value)
		{	
			$query="update members set oto2=1 where id='$x'";
			$q->query($query);
		}
	header("location:members.php?page=$membership_search_url");
	exit;
	}
	if ($action=="reset")
	{
		$t->set_file("content", "admin.reset.password.html");
		$t->set_var("members", count($check));
		$t->set_var("membership_search_url", urlencode($membership_search_url));
		$memberss="|";
		foreach ($check as $x => $value)
		{	
			
			$memberss.=$x."|";
		}
		$t->set_var("member_ids", $memberss);
		$t->set_var("reset_email_body", get_setting("reset_email_body"));
		$t->set_var("reset_email_subject", get_setting("reset_email_subject"));
		GetTags($tags, "{}");
		if (strlen($tags)==0) $t->set_var("tag_list", "");
		else
		{
			$t->set_var("tag_list", $tags);
		}
	}
	}
	else { header("location:members.php?page=$membership_search_url");
	exit; }
	
	include "inc.bottom.php";
?>