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
    print "<pre>\n";
    print_r($item);
    print "</pre>\n";
  }

  function upgrade() {
    return $this->install();
  }

  function install() {
    $model = new modelGenstaller;
    $package = BMGHelper::_req('id');

    // TODO: check ident is valid
    # Get the URL for the download
    $url = $model->retrievedownloadlink($package);
    if (!$url) {
      BMGHelper::setFlash('alert', "Could not retrieve download link for package.");
      return $this->view();
    }

    /* This system can handle only zip files */
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





