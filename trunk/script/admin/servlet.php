<?php

require_once('../lib/init.inc.php');
require_once('admin/mwgadmin.class.php');
$mwg = MWG::getInstance();

@session_start();
mwg_check_admin_login(true);
/*
$admin_logged_in = false;
if (isset($_SESSION['admin_sess_id']) && $_SESSION['admin_sess_id'] == md5($mwg->get_setting("secret_string")."-".ADMIN_PASSWORD))
{
  $admin_logged_in = true;
} else {
   session_destroy();
   header("location:login.php");
   die();
}
*/

$request  = $mwg->request;
$response = $mwg->response; 

$dispatcher = $response->dispatcher;

$doView = true;
if ($request->isPost()) {
  # We determine the method by _cmd_method()
  $keys = array_keys($request->req);
  foreach ($keys as $cmd) {
    if (strpos($cmd, '_cmd_') === 0) {
      $cmd_array = explode('_', $cmd);
      $action= $cmd_array[2];
    }
  }
  if ($action == '') $action = $request->safeGet('a', 'default');

  $module  = strtolower($request->safeGet('m'));
  $method = 'do' . ucwords($action) . 'Store';

  $instance =  $dispatcher->ClassFactory($module);
  $request->objStore = $instance;
  call_user_func(array($instance, $method), $request, $response);
  exit(0);
}

$dispatcher->dispatch($request, $response);
$dispatcher->decorate($response);



