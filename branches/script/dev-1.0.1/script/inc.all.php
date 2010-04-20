<?php
/**
* @version    $Id$
* @package    MWG
* @copyright  Copyright (C) 2010 Intellispire, LLC. All rights reserved.
* @license    GNU/GPL v2.0, see LICENSE.txt
*
* Marketing Website Generator is free software. 
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

require_once('lib/init.inc.php');      // MWG
$valid_sess_ref = array("/index.php");
if (!in_array($_SERVER['PHP_SELF'],$valid_sess_ref)) {
  @session_start();
}
require_once("lib/inc.db_mysql.php");
require_once("lib/inc.template.php");
require_once("lib/inc.payment.functions.php");
require_once('lib/mwg/frontend.php');  // MWG 
$mwg = MWG::getInstance(); // MWG


if (!in_array($_SERVER['PHP_SELF'],$valid_sess_ref)) {
  foreach($_SESSION as $key_ses_1=>$value_ses_1){
    $var_ses_1 = $key_ses_1;
    $$var_ses_1 = $value_ses_1;
  }
}
function mysql_real_escape_array($t){
  return array_map("addslashes",$t);
}
foreach($_GET as $key_get_1=>$value_get_1){
  $var_get_1 = $key_get_1;
  if(is_array($value_get_1)){
    $$var_get_1 = mysql_real_escape_array($value_get_1);
    $_GET[$key_get_1]=mysql_real_escape_array($value_get_1);
  }else{
    $$var_get_1 = addslashes($value_get_1);
    $_GET[$key_get_1]=addslashes($value_get_1);
  }
}
foreach($_POST as $key_post_1=>$value_post_1){
  $var_post_1 = $key_post_1;
  if(is_array($value_post_1)){
    $_POST[$key_post_1]=mysql_real_escape_array($value_post_1);
    $$var_post_1 = mysql_real_escape_array($value_post_1);
  }else{
    $_POST[$key_post_1]=addslashes($value_post_1);
    $$var_post_1 = addslashes($value_post_1);
  }
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
//define database object 
class CDb extends DB_Sql
{
  var $classname = "CDb";
  var $Host=DB_HOST;
  var $Database=DB_NAME;
  var $User=DB_USER;
  var $Password=DB_PASSWORD;
  function haltmsg($msg)
  {
    $t = new Template("templates", "keep");
    $t->set_file("error", "error.html");
    if (DEBUG_TYPE=="browser" || DEBUG_TYPE=="be")
    {
      $t->set_var("sitename", SITENAME);
      $t->set_var("details", "Database error: $msg<br><b>MySQL Error</b>:".$this->Errno." ".$this->Error);
    }
    else
      if (DEBUG_TYPE=="email" || DEBUG_TYPE=="be")
      {
        mwg_mail(EM_SEND_DB_ERR, SITENAME." Mysql Error", "Database error: $msg<br><b>MySQL Error</b>:".$this->Errno." ".$this->Error, "From: ".SITENAME."<noreply@noreply.com>");
        $t->set_var("sitename", SITENAME);

      }
      $t->pparse("out", "error");
    die();
  }
}
	
	
$t = new Template("templates", "remove");
require_once("lib/inc.general.functions.php");
require_once("config/constants.php");
$q = new Cdb;
	
define("SITENAME", get_setting("site_name")); // the name of the site as will be replaced in all {sitename} instances
$mwg->start(); // MWG
  

