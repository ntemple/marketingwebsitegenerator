<?php 
	
	include("inc.top.php");
	if ($from_html){
		$q->query("UPDATE settings SET description='from html' WHERE name='meta-description'");
	}else{
		$q->query("UPDATE settings SET value='$description', description='' WHERE name='meta-description'");
	}
	$what = array ("/,\s+/","/\n*?/","/\s+,/");
	$with = array (",","",",");
	$keywords = preg_replace($what,$with,$keywords);
	$keywords = trim($keywords);
	$q->query("UPDATE settings SET value='$keywords' WHERE name='keywords'");
	
	header("location:keywords.php");
?>