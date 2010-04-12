<?php 
	include "inc.all.php";
	if (get_setting('site_full_url')=="") {
		$site_full_url="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
		$site_full_url=str_replace("admin", "", $site_full_url);
		$query="UPDATE settings SET value='$site_full_url' WHERE name='site_full_url'";
		mysql_query("$query");
	}
	$t->set_file("content", "admin.login.html");
	
	$t->set_var("sitename", SITENAME);
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$final=$t->pparse2("out", "content");
echo $final;	
	?>