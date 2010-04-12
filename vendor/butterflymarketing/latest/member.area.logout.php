<?php 
	session_start();
	session_destroy();
include("inc.all.php");	
	if (get_setting('logout_redirect_url') != ''){
		header("Location: ".get_setting('logout_redirect_url'));
		exit();
	}else{
		header("Location: logout.php");
		exit;
	}
?>