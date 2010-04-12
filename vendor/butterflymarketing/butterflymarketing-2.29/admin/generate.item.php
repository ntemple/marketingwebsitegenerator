<?php 
include("inc.top.php");
	$t->set_file("content", "admin.generate.item.html");
	GetPayButtonsList($t);
	GetTags($tags);
	if (strlen($tags)==0) $t->set_var("tag_list", "");
	else
	{
		$t->set_var("tag_list", $tags);
	}
	
include("inc.bottom.php");
	
?>