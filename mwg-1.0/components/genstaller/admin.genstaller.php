<?php

defined('_MWG') or die ('Restricted Access');

define('UPDATER_SERVER',  'http://www.intellispire.com/network/server51/soap.php');
define('UPDATER_VERSION', 22);
define('UPDATER_MANIFEST', BMGHelper::path(GENSTALL_BASEPATH . '/config/manifest.yml.php'));

require_once (BMGHelper::path(GENSTALL_BASEPATH . '/lib/isnclient/utils.inc.php'));
require_once (BMGHelper::path(GENSTALL_BASEPATH . '/lib/isnclient/intellispireNetworkClient.class.php'));
require_once (BMGHelper::path(GENSTALL_BASEPATH . '/lib/isnclient/manifest.class.php'));
require_once ('modelgenstaller.class.php');

$c     = new comGenstaller;
$t->set_var('submenu', $c->submenu);

$task = BMGHelper::_req('t', 'view');
$func = array($c, $task);
if (is_callable($func)) {
  call_user_func($func);
} else {
  print $task;
  $c->view();
}

class comGenstaller {

  function submenu() {
    return 'submenu';
  }

  function view($class = '', $msg = '') {
    if ($msg) {
      BMGHelper::setFlash($class, $msg);
    }

    $model = new modelGenstaller();

    try {
      $manifest = $model->getManifest();
      $items = $manifest->getItems();
      $registry = BMGenRegistry::getInstance();
      $extensions =  $registry->findExtensions();

      include('admin.genstaller.view.php');

    } catch(Exception $e) {
      BMGHelper::setFlash('alert', $e);
      print "Please try again.";
    }

  }

  function details() {
    $model = new modelGenstaller;
    $manifest = $model->getManifest();
    $item = $manifest->getItem(BMGHelper::_req('id'));

    // $packagedata = $swl[$package];
//    print "<pre>\n";
//    print_r($item);
//    print "</pre>\n";
  }

  function upgrade() {
    return $this->install();
  }

  function install() {
    $model = new modelGenstaller();
    $manifest = $model->getManifest();    
    
    $ex = null;
    try {
      if (isset($_POST['id'])) {
        $id = $_POST['id'];
      } else {
        throw new Exception("Need a package to install! (id is empty)");
      }

      // TODO: check ident is valid
      # Get the URL for the download
      $url = $model->retrievedownloadlink($id);      
      if (!$url) {
        throw new Exception("Could not retrieve download link for package $id.");
      }
      $pkgdata = $manifest->getItem($id);
      if (! $pkgdata) {
        throw new Exception("Sorry, I don't know anything about $id.");
      }
      
      switch($pkgdata['type']) {
#        case 'software':  
#        case 'component':  list($section, $ident) = explode('.', $package);
#                           $installpath = BMGHelper::path (GENSTALL_BASEPATH . "/components/$ident");
#                           break;
        case 'module':    $installpath = BMGHelper::path (GENSTALL_BASEPATH . "/modules/$subtype/"); break;
        case 'plugin':    $subtype = 'shortcodes';
                          $installpath = BMGHelper::path (GENSTALL_BASEPATH . "/plugins/$subtype/"); break;
        case 'theme':     $installpath = BMGHelper::path (GENSTALL_BASEPATH . "/themes/"); break;
        default: throw new Exception("Can't install $id of type {$pkgdata[type]} because I don't what it is");
      }

      if (! is_dir($installpath)) {
         if (! @mkdir($installpath, 0755, true)) throw new Exception("Can't create install directory: $installpath");
      }
            
      $pkg = BMGHelper::url_retrieve($url);
      if (!$pkg) throw new Exception('Could not download package file');
      $path =    GENSTALL_BASEPATH . "/tmp/installer/";
      if (! @mkdir($path, 0755, true)) throw new Exception("Can't create install directory: $installpath");      
      file_put_contents("$path/package.zip", $pkg);
      try {
        BMGHelper::unzip("$path/package.zip", $installpath);
      } catch (Exception $e) {
        // do nothing, just give us a chance to cleanup
        $ex = $e;
      }
      unlink("$path/package.zip");
      rmdir($path);
      if ($ex) throw ($ex);
    } catch (Exception $e) {
        BMGHelper::setFlash('alert', $e->getMessage());
        return $this->view();
    }
    return $this->view('info', 'Package installed.');
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
      $this->view();
    }

    BMGHelper::setFlash('info', 'Manifest downloaded Ok.');
    $this->view();
  }
}





