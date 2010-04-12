<?php
	include ("inc.top.php");
	FFileRead("../templates/butterfly.css.html", $css_file);
	$css_file=str_replace("{font}", $font, $css_file);
	$css_file=str_replace("{size}", $size, $css_file);
	
	FFileWrite("../css/butterfly.css", $css_file);
	header("location: css.php");
?>