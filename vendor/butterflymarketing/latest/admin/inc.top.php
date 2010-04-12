<?php 
require_once("inc.all.php");
if (!$admin_sess_id)
{
	header("location:login.php");
	die();
}
if (isset($admin_sess_id))
{
	if ($admin_sess_id!=md5(get_setting("secret_string")."-".ADMIN_PASSWORD))
	{
		session_destroy();
		header("location:login.php");
		die();
	}
}
?>