<?php 
	include("inc.top.php");
	$t->set_file("content", "admin.keywords.html");
	
	$t->set_var("keywords",get_setting("keywords"));
	$t->set_var("description",get_setting("meta-description"));
	include("inc.bottom.php");
?>