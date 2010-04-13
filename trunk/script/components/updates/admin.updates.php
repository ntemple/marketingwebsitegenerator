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
    $e = null;
    $url = 'http://network.intellispire.com/mwg/latest-update.zip';
    
    try {
      $path = GENSTALL_BASEPATH . "/tmp/upgrade";
      $ppath = "$path/package.zip";
      if (! is_dir($path)) {  
        if (! @mkdir($path, 0777, true)) throw new Exception('Cannot create temporary directory. Please make sure all files are writeable by the webserver. Aborting');
      }

      if (file_exists($ppath)) {
        if (! @unlink($ppath)) throw new Exception('Cannot create temporary file. Please make sure all files are writeable by the webserver. Aborting');
      }

      $pkg = BMGHelper::url_retrieve($url);

      if (! file_put_contents($ppath, $pkg)) throw new Exception('Cannot store package file. Please make sure all files are writeable by the webserver. Aborting');
      if ( BMGHelper::unzip($ppath, GENSTALL_BASEPATH . '/' < 1)) {
        throw new Exception('Could not unpack package. Please make sure all files are writeable by the webserver. Aborting');
      }
      @unlink($ppath);
      @rmdir($path);
      return $this->view('info', 'Update Complete.');
    } catch (Exception $e) {
      return $this->view('alert', $e->getMessage());
    }
  }
}


