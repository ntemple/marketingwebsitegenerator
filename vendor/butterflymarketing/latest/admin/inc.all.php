<?php 
@session_start();
require_once("../lib/inc.db_mysql.php");
require_once("../lib/inc.template.php");
foreach($_SESSION as $key_ses_1=>$value_ses_1){
	$var_ses_1 = $key_ses_1;
	$$var_ses_1 = $value_ses_1;
}
foreach($_GET as $key_get_1=>$value_get_1){
	$var_get_1 = $key_get_1;
	$$var_get_1 = $value_get_1;
}
foreach($_POST as $key_post_1=>$value_post_1){
	$var_post_1 = $key_post_1;
	$$var_post_1 = $value_post_1;
}
foreach($_ENV as $key_env_1=>$value_env_1){
	$var_env_1 = $key_env_1;
	$$var_env_1 = $value_env_1;
}
foreach($_SERVER as $key_server_1=>$value_server_1){
	$var_server_1 = $key_server_1;
	$$var_server_1 = $value_server_1;
}
foreach ($_FILES as $key_file_1 => $value_file_1){ 
    $GLOBALS[$key_file_1] = $_FILES[$key_file_1]['tmp_name']; 
    foreach ($value_file_1 as $ext_file_1 => $value2_file_1){ 
            $key2_file_1 = $key_file_1.'_'.$ext_file_1; 
            $GLOBALS[$key2_file_1] = $value2_file_1; 
    } 
} 
class CDb extends DB_Sql
{
		var $classname = "CDb";
		var $Host=DB_HOST;
		var $Database=DB_NAME;
		var $User=DB_USER;
		var $Password=DB_PASSWORD;
		function haltmsg($msg)
		{
			$t = new Template("../templates", "keep");
			$t->set_file("error", "error.html");
			if (DEBUG_TYPE=="browser" || DEBUG_TYPE=="be")
			{
				$t->set_var("sitename", SITENAME);
				$t->set_var("details", "Database error: $msg<br><b>MySQL Error</b>:".$this->Errno." ".$this->Error);
			}
			else
			if (DEBUG_TYPE=="email" || DEBUG_TYPE=="be")
			{
				@mail(EM_SEND_DB_ERR, SITENAME." Mysql Error", "Database error: $msg<br><b>MySQL Error</b>:".$this->Errno." ".$this->Error, "From: ".SITENAME."<noreply@noreply.com>");
				$t->set_var("sitename", SITENAME);
				
			}
			$t->pparse("out", "error");
			die();
		}
	}
	
	$t = new Template("../templates", "keep");
	require_once("../lib/inc.general.functions.php");
	require_once("../config/constants.php");
	define("SITENAME", get_setting("site_name")); // the name of the site as will be replaced in all {sitename} instances
	$q = new Cdb;
?>