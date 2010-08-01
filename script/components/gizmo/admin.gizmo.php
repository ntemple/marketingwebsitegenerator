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

  defined('_MWG') or die ('Restricted Access');
  mwg_check_admin_login(true); // Redirect if not admin

  if (! class_exists('mwgBaseGizmo')) require_once('mwg/mwgBaseGizmo.class.php');
  if (! class_exists('modelGizmo')) require_once('modelgizmo.class.php');

  $request   = MWG::getInstance()->request;
  $response  = MWG::getInstance()->response;

  $component   = new comGizmo($request->get('c'));

  // @todo: put menu in response
  $t->set_var('submenu', $component->submenu()); 

  // @todo: proper flash messages 
  if ($request->get('msg')) {
    MWGHelper::setFlash($request->get('class'), $request->get('msg'));
  }

  $task = $request->get('t', 'view');
  $func = array($component, $task);
  if (is_callable($func)) {
    call_user_func($func, $request, $response);
  } else {
    print $task;
  }


  class comGizmo {

    var $controller_name;
    var $model;

    function __construct($controller_name) {
      $this->controller_name = $controller_name;
      $this->model = new modelGizmo();
    }

    function submenu() {
      $tasks = array(
      'Manage Gizmos' => 'view',
      'New Gizmo'     => 'shownew'
      );

      $items = array();
      foreach ($tasks as $disp => $task) {
        $items[] = "<a href='?c={$this->controller_name}&t=$task'>$disp</a>";
      }
      return $items;
    }

    function link_to($id, $task, $controller=null) {
      if ($controller == null) $controller = $this->controller_name;    
    }

    function shownew(mwgRequest $request, mwgResponse $response) {
      if ($msg) {
        MWGHelper::setFlash($class, $msg);
      }
      $gizmos_mf = $this->model->listGizmos();    
      
      require_once('admin.gizmo.shownew.php');
    }

    function view(mwgRequest $request, mwgResponse $response) {
// @todo: fix, $msg is out of scope
//      if ($msg) {
//        MWGHelper::setFlash($class, $msg);
//      }
      $db = MWG::getInstance()->getDb();
      $gizmos = $db->get_results('select * from mwg_gizmo');
      
      require_once('admin.gizmo.view.php');      
   }

       
    function details(mwgRequest $request, mwgResponse $response)  {
      
      $id = $request->get('id');
      $row = null;
      if ($id) {
        $db = MWG::getInstance()->getDb();
        $row = $db->get_row('select * from mwg_gizmo where id=? limit 1', $id);
      }

      if ($row) {
        $identity = $row['identity'];
      } else {
        $identity = $request->get('identity');
      }
      $gizmo = $this->model->gizmoFactory($identity);    
      $gizmo->hydrate($row);

      $check_active_1 = '';
      $check_active_0 = '';
      
      if ($gizmo->active) {    
        $check_active_1 = 'checked';
      } else {
        $check_active_0 = 'checked';
      }
      
      
      if ($gizmo->display_title) {    
        $check_display_title_1 = 'checked';
        $check_display_title_0 = '';
      } else {
        $check_display_title_1 = '';
        $check_display_title_0 = 'checked';
      }
      
      
      
      $select_position = array( $gizmo->position => 'selected');
      
      include('admin.gizmo.details.php');
  }

  function gizmo_store(mwgRequest $request, mwgResponse $response) {

    $identity = $request->get('identity');
    $id       = $request->get('id');
    if (! $identity) return $this->redirect('view','Missing Gizmo Identity', 'error');
        
    $gizmo = $this->model->gizmoFactory($identity);
    $gizmo->params   = $gizmo->extractAdminFormData($request);
    $gizmo->identity = $identity;
    $gizmo->name     = $request->get('name');
    $gizmo->title    = $request->get('title');
    $gizmo->active   = $request->get('active', 0);
    $gizmo->position = $request->get('position', 'Invocation');
    $gizmo->ordre    = $request->get('ordre', 0);
    $gizmo->display_title  = $request->get('display_title', 0);
    $gizmo->display_group  = $request->get('display_group', '');
    $gizmo->display_hidden = $request->get('display_hidden', 0);

        
    if ($id) $gizmo->id = $id;
    
    $gizmo->store();

    if ($request->get('cmd_apply', 0)) // We want to "apply"
       $this->redirect('details&id=' . $gizmo->id, 'Gizmo Saved.', 'info');
    else 
       $this->redirect('view', 'Gizmo Saved.', 'info');
  }

  function redirect($task, $message = '', $class = 'info') {
    $link = "controller.php?c={$this->controller_name}&t=$task";

    /** @todo proper flash variables */
    if ($message) $link .= "&msg=". urlencode($message);
    if ($class) $link .= "&class=$class";

    header("Location: $link");
    exit();    
  }  
}

