<?php

require_once('../lib/init.inc.php');
require_once('admin/mwgadmin.class.php');
$mwg = MWG::getInstance();

@session_start();
$admin_logged_in = false;
if (isset($_SESSION['admin_sess_id']) && $_SESSION['admin_sess_id'] == md5($mwg->get_setting("secret_string")."-".ADMIN_PASSWORD))
{
  $admin_logged_in = true;
} else {
   session_destroy();
   header("location:login.php");
   die();
}

$request  = $mwg->request;
$response = $mwg->response; 

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

  $instance =  ClassFactory($module);
  $request->objStore = $instance;
  call_user_func(array($instance, $method), $request, $response);
  exit(0);
}

dispatch($request, $response);
decorate($response);

# ============

function classFactory($module) {
  $class     = $module . 'Actions';
  $classfile = "$class.class.php";
  require_once($classfile);
  $instance = new $class;
  return $instance;
}


function dispatch($request, $response) {
  # @todo routing for SEF urls

  $module  = strtolower($request->safeGet('m'));
  $action  = strtolower($request->safeGet('a', 'default'));

  $instance =  ClassFactory($module);

  # default template
  $response->_template = $module . "_" . $action . "_view.html";
  $response->viewObj = $instance; // allows template to access the view object

  $method = 'do' . ucwords($action) . 'View';
  if (! method_exists($instance, $method) ) $method = 'doView';

  try {
   call_user_func(array($instance, $method), $request, $response);
  } catch (Exception $e) {
    throw $e;
  } 
  return $instance;
}



function decorate($response) {
  $response->content = $response->getOutput(); // Parse the content
  $response->head    = $response->_head;
  

  $response->getFlash();

  if (! $response->message) {
  try {  
    if (needsUpdate($current, $latest)) {
      $response->setFlash("Update found! New Version $latest You are running $current.
                           <a href='controller.php?c=updates'>Please upgrade now!</a>", 'warn');
    }
  } catch(Exception $e) {
    $response->setFlash("Could not reach update server. Please try again.<br> $e", 'alert');
  }
  $response->getFlash();
  }
  // $submenu = $t->get_var('submenu');

  $gs = BMGenStaller::getInstance();
  if (isset($_GET['c']))
    $component = $_GET['c'];
  else
    $component = '';

  if (isset($_GET['menu'])) {
    $_SESSION['menu'] = $_GET['menu'];
  }

  $select_menu = $_SESSION['menu'];

  $response->component_menu = $gs->getComponentMenuItems($component);
  $response->menu = $gs->getStandardMenuItems($select_menu);
  $response->li_menu = $gs->getMainMenu($select_menu);


  if (!$submenu) {
    $path = MWG_BASE . '/admin/templates/submenu/admin.main.'. $select_menu . ".html";
    if (file_exists($path)) $response->submenu = file_get_contents($path);
  }

  $response->newmessages = MWG::getDb()->get_value('select count(*) from messages where member_id=1 and read_flag=0');
  $response->sitename = MWG::getInstance()->get_setting("site_name");
  $response->version = trim(file_get_contents(MWG_BASE .'/config/version'));


  // content, menu, component_menu, message, head
  $response->output('layout.html');
}

