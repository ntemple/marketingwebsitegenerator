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

$c     = new comThemes;
$t->set_var('submenu', $c->submenu());

$task = BMGHelper::_req('t', 'view');
$func = array($c, $task);
if (is_callable($func)) {
  call_user_func($func);
} else {
  print $task;
  $c->view();
}

class comThemes {
  
  function submenu() {
  }

  function view($class = '', $msg = '') {
    if ($msg) {
      BMGHelper::setFlash($class, $msg);
    }
    
    $mwg = MWG::getInstance();
    $items = $mwg->theme->getThemes();
    require_once('admin.themes.view.php');
  }
  
  function activate() {    
    $mwg = MWG::getInstance();
    if (isset($_POST['_cmd_activate_be'])) {
        $mwg->registry->set('theme.defaultbe', BMGHelper::_req('id'));      
    }  else {
       $mwg->registry->set('theme.default', BMGHelper::_req('id'));
    }
    $mwg->theme->switchThemes('');
    $this->view('info', "New Theme activated.");       
    
  }

}




