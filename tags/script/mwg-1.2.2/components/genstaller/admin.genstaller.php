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

define('UPDATER_SERVER',  'http://www.intellispire.com/network/server51/soap.php');
define('UPDATER_VERSION', 22);
define('UPDATER_MANIFEST', MWGHelper::path(GENSTALL_BASEPATH . '/config/manifest.yml.php'));

require_once (MWGHelper::path(GENSTALL_BASEPATH . '/lib/isnclient/utils.inc.php'));
require_once (MWGHelper::path(GENSTALL_BASEPATH . '/lib/isnclient/intellispireNetworkClient.class.php'));
require_once (MWGHelper::path(GENSTALL_BASEPATH . '/lib/isnclient/manifest.class.php'));
require_once ('modelgenstaller.class.php');

$c     = new comGenstaller($_GET['c']);
$t->set_var('submenu', $c->submenu());

$task = MWGHelper::_req('t', 'view');
$func = array($c, $task);
if (is_callable($func)) {
  call_user_func($func);
} else {
  print $task;
  $c->view();
}

class comGenstaller {

  function __construct($controller_name) {
    $this->controller_name = $controller_name;
    $this->model = new modelGenstaller();
  }

  function submenu() {
    return '';
  }


  function view($class = '', $msg = '') {
    if ($msg) {
      MWGHelper::setFlash('gt-notice', $msg);
    }
    $model = new modelGenstaller();
    try {
      $manifest = $model->getManifest();
      $items = $manifest->getItems();
      $registry = mwgDataRegistry::getInstance();
      $extensions =  $registry->findExtensions();
      $username = $registry->get('username');


      include('admin.genstaller.view.php');

    } catch(Exception $e) {
      MWGHelper::setFlash('alert', $e);
      print "Please try again.";
    }

  }

  function details() {
    $model = new modelGenstaller;
    $manifest = $model->getManifest();
    $item = $manifest->getItem(MWHelper::_req('id'));
  }

  function upgrade() {
    return $this->install();
  }

  /**
  * A manifest must exist either:
  * -- at the top level
  * -- if there is exactly 1 directory, then in that directory
  * 
  * A manifest is a .yml.php file with an identity tag that 
  * 
  * @param mixed $dir
  */
  function findManifest($base, $recurse = true) {
    $dir = null;
    $files[] = array();
    $result = array();

    if ($handle = opendir($base)) {
      while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != '.svn') {  
          if (is_dir("$base/$file")) {
            $dir = "$base/$file";
          } else {
            if (strpos($file, '.yml.php') > 1) {
              $files[] = "$base/$file";
            }              
          }
        }
      }
      closedir($handle);
    }

    foreach ($files as $file) {
      $mf = Spyc::YAMLLoad($file);
      if (isset($mf['identity'])) {
        $result['base'] = $base;
        $result['file'] = $file;
        $result['mf']   = $mf;
        return $result;            
      }
    }
    // Still haven't found it? Try one level down ....
    if ($dir && $recurse) {
      return $this->findManifest($dir, false);
    }
    return false;

  }

  function package_install($package) {
    if (! file_exists($package)) {
      throw new Exception("Can't open package: $package");
    }


    $uid = substr(md5(time() . serialize($GLOBALS)), 1,8);
    $package_tmp_path = MWG_BASE . "/tmp/$uid";

    if (! @mkdir($package_tmp_path, 0755, true)) {
      unlink($package);
      throw new Exception("Can't create install directory: $package_tmp_path"); 
    }

    try {
      BMGHelper::unzip($package, $package_tmp_path);
    } catch (Exception $e) {
      MWGHelper::rmdir_recurse($package_tmp_path);
      throw($e);
    }

    // At this point we have the package unzipped in $package_tmp_path
    $result = $this->findManifest($package_tmp_path);
    if (!$result) {
      MWGHelper::rmdir_recurse($package_tmp_path);
      throw new Exception("Invalid Package file, missing manifest");
    } 

    $mf = $result['mf'];
    $srcdir = $result['base'];
    $file = $result['file'];

    $identity = strtolower($mf['identity']);
    $ident = explode('.', $identity);    
    $sw   = $ident[0];
    $type = $ident[1];
    $name = $ident[2];

    $error = false;
    if ($sw != 'mwg') $error = true;
    if (!$type ) $error = true;
    if (!$name ) $error = true;
    if ($error) throw new Exception("Invalid Identity: $identity");

    switch($type) {
      case 'package':    break;
      case 'components': $installpath = MWG_BASE . "/$type/$name/"; break;      
      case 'themes':     $installpath = MWG_BASE . "/$type/$name/"; break;      
      case 'gizmos':     $installpath = MWG_BASE . "/$type/"; break;
      case 'plugins':    $subtype = $ident[2];
        $name    = $ident[3];
        $installpath = MWG_BASE . "/$type/$subtype/$name"; break;
      default: throw new Exception('Unknown package type:' . $type);
    }

    if ($type == 'package') {
      $packages = $mf['packages'];
      foreach ($packages as $package_name) {
        $package = $srcdir . "/$package_name";
        if ( (strpos($package, '.zip') > 1) && file_exists($package)) {
          try {
            $this->package_install($package);
          } catch (Exception $e) {
            $exceptions[] = $e;
          }        
        }
      } // packages
    }

    if (!is_dir($installpath)) {
      if (! @mkdir($installpath, 0755, true)) throw new Exception("Can't create install directory: $installpath");      
    }
    MWGHelper::dir_copy($srcdir, $installpath);
    MWGHelper::rmdir_recurse($package_tmp_path);
    return true;
  }

  function install() {
    try {
      $model = new modelGenstaller();
      $manifest = $model->getManifest();    
      $request = MWG::getInstance()->request;
 
     // Find the  package URL
      $url = $request->get('package');
      $id = $request->get('id');
      
      if ($id) {
        $url = $model->retrievedownloadlink($id);  
      }
                 
      $uid = substr(md5(time() . serialize($GLOBALS)), 1,8);
      $package =  MWG_BASE . "/tmp/$uid.zip";
      $package_tmp_path = MWG_BASE . "/tmp/$uid";
      if ($url) {
        $pkgdata = MWGHelper::url_retrieve($url);
        file_put_contents($package, $pkgdata);
      } else {
        if (isset($_FILES['package']['tmp_name']))
          move_uploaded_file($_FILES['package']['tmp_name'], $package);
      }
      if (! file_exists($package)) {
        throw new Exception("Can't write temporary path: $package");
      }

      try {
        $this->package_install($package);
      } catch(Exception $e) {
        @unlink($package);
        throw $e;
      }
      @unlink($package);


      return $this->view('info', "Package $identity installed.");
    } catch (Exception $e) {
      return $this->view('warn', $e->getMessage());
    }
  }


  function install_software() {
    list($section, $ident) = explode('.', $package);

    $installpath = BMGHelper::path (GENSTALL_BASEPATH . "/components/$ident");
    @mkdir($installpath);

    $pkg = BMGHelper::url_retrieve($url);
    $ppath = BMGHelper::path (GENSTALL_BASEPATH . "/components/$ident/package.zip");
    file_put_contents($ppath, $pkg);
    BMGHelper::unzip($ppath, $installpath);
    unlink($ppath);

    $installfile = BMGHelper::path("$installpath/install.$ident.php");
    if (file_exists($installfile)) {
      include($installfile);
    } else {
      BMGHelper::setFlash('warn', "Package extracted, but no install file found.");
    }
    return;
  }

  function loadmanifest() {
    $model = new modelGenstaller;

    try {
      $manifest = $model->retrieveManifest();
    } catch(Exception $e) {
      BMGHelper::setFlash('alert', $e);
      return $this->view();
    }

    BMGHelper::setFlash('info', 'Manifest downloaded Ok.');
    $this->view();
  }

  function activate() {
    $registry = mwgDataRegistry::getInstance();
    $request = MWG::getInstance()->request;

    $model = new modelGenstaller;
    try {
      $status = $model->checkAuth($_POST['username'], md5($_POST['password']));
    } catch(Exception $e) {
      BMGHelper::setFlash('alert', $e);
      return $this->view();    
    }

    if ($status) {
      $registry->set('username', $_POST['username']);
      $registry->set('password', md5($_POST['password']));
      return $this->view('info', "MWG Registered");        
    } else {
      return $this->view('warn', "MWG Not Registered - check username and password.");
    }    
  }  
}

