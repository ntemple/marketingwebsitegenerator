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

defined('_MWG') or die( 'Restricted access' );

require_once('isnclient/spyc.php');
require_once('admin/mwghelper.class.php');
require_once('mwg/mwgDataRegistry.class.php');

class BMGenStaller {

  /** @var mwgDataRegistry */
  var $registry = null;

  static function getInstance() {
    static $self = null;

    if (! $self) {
      $self = new self;
    }
    return $self;
  }

  private function __construct() {
    $this->registry = mwgDataRegistry::getInstance();
  }

  function getComponentMenuItems($selected) {
    $fullmenu = $this->registry->getMenu();
    $menu = '';

    foreach ($fullmenu as $k => $v) {
      if (is_scalar($v)) {
        //$items[$k] = $v;
        if ($selected == $k) {
          $class = 'a_selected';
        } else {
          $class = 'a';
        }
        if ($menu) $menu .= ' | ';
        $menu .= "<a href='controller.php?c=$k' class='$class'>$v</a>";
      }
    }
    //return $items;
    return $menu;
  }
  
  function getStandardMenuItems($selected) {
    $items = array(
      'settings'   => '<a href="index.php?menu=settings" class="a">Settings</a>',
      'members'    => '<a href="members.php?menu=members" class="a">Members</a>',
      'design'     => '<a href="promo.tools.php?menu=design" class="a">Site Design</a>',
      'membership' => '<a href="membership.php?menu=membership" class="a">Membership Configuration</a>',
      'help'       => '<a href="helpdesk.php?menu=help" class="a">Help Desk({newmessages})</a>',
   );
   
   $menu = '';
   foreach ($items as $item => $link) {
      if ($item == $selected) {
        $link = str_replace('class="a"', 'class="a_selected"', $link);
      }
      $menu .= "$link | ";     
   }
  
   $menu .= '<a href="logout.php" class="a">Logout</a>';
   return $menu;
    
  }
  

  function getVersion() {
    static $version;
    if (!$version)       
      return $version;

  }    


  function check_version() {
    $version = $this->getVersion();
    require_once(GENSTALL_BFPATH . '/components/genstaller/genstaller.class.php');

  }

}

function genstall_admin_start() {
  $gs = BMGenStaller::getInstance();
  ob_start();
}

function Ogenstall_admin_end($t, $ocontent, $notemplate) {

  $msg = '';
  try {
    if (needsUpdate($current, $latest)) {
      $msg = "<div class='warn'>Update found! New Version $latest You are running $current.<br /> <a href='controller.php?c=updates'>Please upgrade now!</a></div>";
    }
  } catch(Exception $e) {
    MWGHelper::setFlash('alert', "Could not reach update server. Please try again.<br> $e");      
  }


  $t->set_var('upgrademsg', $msg); 

  if ($notemplate) {
    echo $ocontent;
  } else {
    $t->set_var("content", $ocontent);
    $t->pparse("out", "main");
  }

  $out = ob_get_clean();
  $content = $out;
  
  /** @var BMGenStaller */
  $gs = BMGenStaller::getInstance();
  // $items = $gs->getMainMenuItems();
  $component = $_GET['c'];
  $new_menu = $gs->getComponentMenuItems($component);

  $orig_menu = '<a href="logout.php" class="a">Logout</a>';
  $out = str_replace($orig_menu, $orig_menu . "<br>\n" . $new_menu, $out);

  $r = mwgDataRegistry::getInstance();
  if ($msg) print "<center><font size='+2'><b>$msg</b></font></center>\n";
  
  $select_menu = $_SESSION['menu'];
  
  $component_menu = $new_menu;
  $menu = $gs->getStandardMenuItems($select_menu);
  
  $newmessages = MWG::getDb()->get_value('select count(*) from messages where member_id=1 and read_flag=0');
  $submenu = $t->get_var('submenu');
  $path = MWG_BASE . '/admin/templates/submenu/admin.main.'. $select_menu . ".html";
  if (file_exists($path)) $submenu = file_get_contents($path);
  
  $head    = '';
  $sitename = SITENAME;     
  $version = file_get_contents(MWG_BASE .'/config/version');
  trim($version);
  trim($version);
  
  ob_start();
  include('templates/admin.main.php');
  $page = ob_get_clean();
  $page = str_replace('{newmessages}', $newmessages, $page);

  print $page;
}

function genstall_admin_end($t, $ocontent, $notemplate) {

  if ($notemplate) {
    echo $ocontent;
  } else {
    $t->set_var("content", $ocontent);
    $t->pparse("out", "main");
  }
  $content = ob_get_clean();

  $msg = '';
  try {
    if (needsUpdate($current, $latest)) {
      $msg = "<div class='warn'>Update found! New Version $latest You are running $current.<br /> <a href='controller.php?c=updates'>Please upgrade now!</a></div>";
    }
  } catch(Exception $e) {
    MWGHelper::setFlash('alert', "Could not reach update server. Please try again.<br> $e");      
  }
  $head = ''; 
  $submenu = $t->get_var('submenu');
  
  $page = mwg_admin_decorate($content, $submenu, $msg, $head);
  print $page;
}


function mwg_admin_decorate($content, $submenu, $message, $head) {
  $gs = BMGenStaller::getInstance();
  if (isset($_GET['c']))  
    $component = $_GET['c'];
  else 
    $component = '';  


  $component_menu = $gs->getComponentMenuItems($component);
  $menu = $gs->getStandardMenuItems($select_menu);

  $select_menu = $_SESSION['menu'];
  if (!$submenu) {
    $path = MWG_BASE . '/admin/templates/submenu/admin.main.'. $select_menu . ".html";
    if (file_exists($path)) $submenu = file_get_contents($path);
  }

  $newmessages = MWG::getDb()->get_value('select count(*) from messages where member_id=1 and read_flag=0');  
  $sitename = SITENAME;     
  $version = trim(file_get_contents(MWG_BASE .'/config/version'));

  
  // content, menu, component_menu. message, head
  ob_start();
  include('templates/admin.main.php');
  $page = ob_get_clean();
  $page = str_replace('{newmessages}', $newmessages, $page);
  return $page;  
}


function needsUpdate(&$current, &$latest) {
  require_once (GENSTALL_BASEPATH . '/components/genstaller/modelgenstaller.class.php');
  $model = new modelGenstaller();
  $manifest = $model->getManifest();
  $latest = trim($manifest->manifest['mwglatest']);
  $current = trim(file_get_contents(GENSTALL_BFPATH . '/config/version'));
  return (version_compare($current, $latest, '<'));
}

