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
require_once('mwg/mwgregistry.class.php');

class BMGenStaller {

  /** @var BMGenRegistry */
  var $registry = null;

  static function getInstance() {
    static $self = null;

    if (! $self) {
      $self = new self;
    }
    return $self;
  }

  private function __construct() {
    $this->registry = BMGenRegistry::getInstance();
  }

  function getMainMenuItems($selected) {
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

function genstall_admin_end($t, $ocontent, $notemplate) {

  $msg = '';
  try {
    if (needsUpdate($current, $latest)) {
      $msg = "<div class='warn'>Update found! New Version $latest You are running $current.<br /> <a href='controller.php?c=updates'>Please upgrade now!</a></div>";
    }
  } catch(Exception $e) {
    BMGHelper::setFlash('alert', "Could not reach update server. Please try again.<br> $e");      
  }


  $t->set_var('upgrademsg', $msg); 

  if ($notemplate) {
    echo $ocontent;
  } else {
    $t->set_var("content", $ocontent);
    $t->pparse("out", "main");
  }



  $out = ob_get_clean();
  /** @var BMGenStaller */
  $gs = BMGenStaller::getInstance();
  // $items = $gs->getMainMenuItems();
  $component = $_GET['c'];
  $new_menu = $gs->getMainMenuItems($component);

  $orig_menu = '<a href="logout.php" class="a">Logout</a>';
  $out = str_replace($orig_menu, $orig_menu . "<br>\n" . $new_menu, $out);

  $r = BMGenRegistry::getInstance();
  if ($msg) print "<center><font size='+2'><b>$msg</b></font></center>\n";
  print $out;
}


function needsUpdate(&$current, &$latest) {
  require_once (GENSTALL_BASEPATH . '/components/genstaller/modelgenstaller.class.php');
  $model = new modelGenstaller();
  $manifest = $model->getManifest();
  $latest = trim($manifest->manifest['mwglatest']);
  $current = trim(file_get_contents(GENSTALL_BFPATH . '/config/version'));
  return (version_compare($current, $latest, '<'));
}

