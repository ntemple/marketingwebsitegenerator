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

  define('_MWG', true);
  include('inc.all.php');
  include('inc.top.php');

  $gs = BMGenStaller::getInstance();
  $t->set_root(GENSTALL_BASEPATH . '/admin/templates');  

  // $tmpl->addpath(BMGHelper::path(GENSTALL_BASEPATH . '/templates'));
  // $t = $tmpl;

  // Determine master template
  // in inc.bottom.php
  // $t->set_file("main", "admin.main.".$_SESSION['menu'].".html");
  $_SESSION['menu'] = 'genstaller';

  $component = $_REQUEST['c'];
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
