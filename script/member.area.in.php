<?php 
include ("inc.all.php");
if (!$pss) {
	get_logged_info();
	if ($q->f("password")==md5(""))	{
		$t->set_file("content", "create.pass.html");
		include("inc.bottom.php");
		die();
	}
	$q->query("SELECT link FROM menus WHERE alogin='1'");
	$q->next_record();
	if($q->nf() == 0) {
		header("Location: member.area.profile.php");
		die();
	}else {
		header("Location: ".$q->f("link"));
		die();
	}
} else {
	$t->set_file("content", "create.pass.html");
	include("inc.bottom.php");
	die();
}
?>