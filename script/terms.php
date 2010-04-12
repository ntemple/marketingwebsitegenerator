<?php 
include("inc.all.php");
	$ar_host=parse_url(get_setting("site_full_url"));
	$host=$ar_host["host"];
	$path=$ar_host["path"];
	$host=str_replace("www","",$host);
	$t->set_file("content", "terms.html");
	
include("inc.bottom.php");
?>