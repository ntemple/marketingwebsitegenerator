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

if (isset($_GET['menu'])) {
  $_SESSION['menu'] = $_GET['menu'];
}
$t->set_file("main", "content.html");

$t->set_var("sitename", SITENAME);
$t->set_var("year", date("Y"));
$ocontent=$t->parse("page", "content");
if ($notemplate)
{
  if ($from) 
  {
    $ocontent=str_replace("{from}", "?from=".$from, $ocontent);
    $_SESSION["from"] = $from;
  }
  $ocontent='<script language=JavaScript src="../editor/scripts/innovaeditor.js"></script>
  <link href="../css/butterfly.css" rel="stylesheet" type="text/css">'.$ocontent;

  $_SESSION["notemplate"] = $notemplate;
}


 
