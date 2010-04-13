<?php

defined('_MWG') or die ('Restricted Access');

require_once (GENSTALL_BASEPATH . '/components/genstaller/modelgenstaller.class.php');

$c     = new comUpdates;
$t->set_var('submenu', $c->submenu);

$task = BMGHelper::_req('t', 'view');
$func = array($c, $task);
if (is_callable($func)) {
  call_user_func($func);
} else {
  print $task;
  $c->view();
}

class comUpdates {

  function submenu() {
    return 'submenu';
  }

  function view($class = '', $msg = '') {
    if ($msg) {
      BMGHelper::setFlash($class, $msg);
    }
    $model = new modelGenstaller();
    try {
      $needsUpdate = needsUpdate($current, $latest);    
    } catch(Exception $e) {
      BMGHelper::setFlash('alert', "Could not reach update server. Please try again.<br> $e");      
    }
    include('admin.updates.view.php');
  }

  function upgrade() {
    $url = 'http://network.intellispire.com/mwg/mwg-latest-update.tgz';
    $pkg = BMGHelper::url_retrieve($url);
    $ppath = BMGHelper::path (GENSTALL_BASEPATH . "/tmp/upgrade/package.zip");
    @mkdir($ppath, 0777, true);
    file_put_contents($ppath, $pkg);
    BMGHelper::unzip($ppath, GENSTALL_BASEPATH);
    unlink($ppath);
//    BMGHelper::setFlash('info', "Package Installed.");
//    BMGHelper::setFlash('warn', "Package extracted, but no install file found.");
    $this->view('info', 'Update Complete.');
  }
}


