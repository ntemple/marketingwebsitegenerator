<?php
/*
  @var t TemplateEx
*/

//  require_once('bmgenstaller.class.php');
//  $gs = BMGenStaller::getInstance();

  define('_MWG', true);
  include('inc.all.php');
  include('inc.top.php');

  $gs = BMGenStaller::getInstance();

  # Extend internal classes
  $tmpl = new TemplateEx();
  $tmpl->init($t);
  // $tmpl->addpath(BMGHelper::path(GENSTALL_BASEPATH . '/templates'));
  $t = $tmpl;

  // Determine master template
  // in inc.bottom.php
  // $t->set_file("main", "admin.main.".$_SESSION['menu'].".html");
  $_SESSION['menu'] = 'genstaller';

  $component = $_GET['c'];
  $component = preg_replace('/[^a-zA-Z0-9\_\-]/', '', $component);

  $component_file = BMGHelper::path(GENSTALL_BASEPATH . "/components/$component/admin.$component.php");
  if (file_exists($component_file)) {
    ob_start();
    include($component_file);
    $content = ob_get_clean();
  } else {
      $content = 'Error: Component ' . $component . ' does not exist. Cannot access file: ' . $component_file;
      BMGHelper::setFlash('warn', 'Cannot load Extension!');
  }

  ob_start();
  include(BMGHelper::path(GENSTALL_BASEPATH . "/templates/message.html"));
  $_msg = ob_get_clean();

  $t->set_var('content', $_msg . $content);



  include('inc.bottom.php');
