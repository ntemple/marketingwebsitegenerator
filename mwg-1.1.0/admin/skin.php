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
/*
if ($_SESSION['menu'] == "settings"){
  $_SESSION['menu'] = "settings";
}elseif ($menu == "members"){
  $_SESSION['menu'] = "members";
}elseif ($_GET['menu'] == "design"){
  $_SESSION['menu'] = "design";                                                           
}elseif ($_GET['menu'] == "membership"){
  $_SESSION['menu'] = "membership";
}elseif ($_GET['menu'] == "help"){
  $_SESSION['menu'] = "help";
}elseif ($_GET['menu'] == "updates"){
  $_SESSION['menu'] = "updates";
}
*/
$t->set_file("main", "admin.main.".$_SESSION['menu'].".html");
$t->set_file("main", "content.html");

//$newmessages = MWG::getDb()->get_value('select count(*) from messages where member_id=1 and read_flag=0');
//$t->set_var("newmessages", $newmessages);

//$t->set_var("version", file_get_contents('../config/version'));
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




 
 
