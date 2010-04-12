<?php
	include ("inc.top.php");
	$t->set_file("content", "admin.css.html");
	FFileRead("../css/butterfly.css", $css);
	preg_match("/(\d+)px/", $css, $match);
	$t->set_var("size", $match[1]);
	preg_match("/(\w+)\;/", $css, $match);
	$t->set_var("font", $match[1]);
	$t->set_var($match[1]."select", "selected");
	include ("inc.bottom.php");
?>
