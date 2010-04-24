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
      return implode(' | ', $items);
    }

    function link_to($id, $task, $controller=null) {
      if ($controller == null) $controller = $this->controller_name;    
    }

    function shownew(mwgRequest $request, mwgResponse $response) {
      // , $msg = '', $class = 'info'
      if ($msg) {
        MWGHelper::setFlash($class, $msg);
      }
      $gizmos_mf = $this->model->listGizmos();    

      $count = 0;
      foreach ($gizmos_mf as $identity => $item) {      
        $count++;
        $link = "?c={$this->controller_name}&t=details&identity=$identity";
        print "$count\t$item[title]\t<a href='$link'>New</a><br />\n";
      }
    }

    function view(mwgRequest $request, mwgResponse $response) {
      if ($msg) {
        MWGHelper::setFlash($class, $msg);
      }

      $db = MWG::getInstance()->getDb();
      $gizmos = $db->get_results('select * from mwg_gizmo');
      foreach ($gizmos as $gizmo) {      
        $edit = "?c={$this->controller_name}&t=details&id=" . $gizmo['id'];
        $delete = "?c={$this->controller_name}&t=details&id=" . $gizmo['id'];
        $activate = "?c={$this->controller_name}&t=details&id=" . $gizmo['id'];
        print "$gizmo[id]\t$gizmo[name]\t[gizmo id='$gizmo[id]']\t<a href='$edit'>edit</a>\t<a href='$delete'>delete</a>\t<a href='$activate'>activate</a><br/>\n";
      }
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

      if ($gizmo->active) {    
        $check_active_1 = 'checked';
      } else {
        $check_active_0 = 'checked';
      }
    ?>
    <h2>Setup Your Gizmo</h2>
    <p>The name is a friendly name so you know what this Gizmo is, it is not displayed. The title may be displayed by some Gizmos, for example, as a heading.</p>
    <form method="post" action="controller.php?">
      <input type="hidden" name="c" value="<?php echo $this->controller_name ?>">
      <input type="hidden" name="t" value="gizmo_store">
      <input type="hidden" name="identity" value="<?php echo $gizmo->identity ?>">
      <input type="hidden" name="id" value="<?php echo $gizmo->id ?>">
      <label for="name" style="line-height:35px;display:block;">Gizmo Name: <input type="text" id="name" name="name" value="<?php echo $gizmo->name ?>" /></label>
      <label for="title" style="line-height:35px;display:block;">Gizmo Title: <input type="text" id="title" name="title" value="<?php echo $gizmo->title; ?>" /></label>

      <br>
      <input type="radio" name="active" value="1" <?php echo $check_active_1 ?>> Active
      <input type="radio" name="active" value="0" <?php echo $check_active_0 ?>> Inactive
      <br>
      <hr>
      <?php echo $gizmo->getAdminForm($gizmo->params) ?>
      <input type="submit" name= "cmd_save" value="Save">
      <input type="submit" name= "cmd_apply" value="Apply">
    </form>
    <!-- <?php print_r($gizmo) ?> -->
    <p>&nbsp;</p>
<?php if ($gizmo->id) { ?>
    <h2>Usage:</h2>
    <p>If this Gizmo is active, simply use the code [gizmo id="<?php echo $gizmo->id ?>"] on any page to display it.</p>
<?php } ?>    
    <h2>Documentation</h2>
    <p><?php echo $gizmo->getDocumentation(); ?></p>
    
    <?php      
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

