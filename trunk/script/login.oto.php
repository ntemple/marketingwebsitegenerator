<?php 
include("inc.all.php");
if (get_setting("otobckeactive")==1)
{
	$t->set_var("email", $_COOKIE["emailx"]);
	$t->set_file("content", "login.oto.html");
}
else
{
	header("location:login.php");
}
include("inc.bottom.php");
?>