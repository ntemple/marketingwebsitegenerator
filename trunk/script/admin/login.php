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


include "inc.all.php";
/*
* This was used to make sure the site_setting was
* set.  We now do that during installation, so not
* necessary. Or should be moved to a toolbox.
* 
*/
/*
$url = get_setting('site_full_url');
if ($url == '') {
//  $site_full_url="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
  //$site_full_url=str_replace("admin", "", $site_full_url);
  $site_full_url = MWG_BASEHREF;
  $query="UPDATE settings SET value='$site_full_url' WHERE name='site_full_url'";
  mysql_query("$query");
}
*/  
$t->set_file("content", "admin.login.html");

$t->set_var("sitename", SITENAME);
$ocontent=$t->parse("page", "content");
$t->set_var("content", $ocontent);
$final=$t->pparse2("out", "content");
echo $final;	
