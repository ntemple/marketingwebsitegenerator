<?php 
session_start();
	include "inc.all.php";
	if ($password==ADMIN_PASSWORD)
	{
		$admin_sess_id=md5(get_setting("secret_string")."-".ADMIN_PASSWORD);
		$_SESSION["admin_sess_id"] = $admin_sess_id;
		header("location:index.php?menu=settings");
	}
	else
	header("location:login.php");
?>