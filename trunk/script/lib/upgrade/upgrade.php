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

/**
* Check the database and peform an upgrade if necessary
* Needs to be very fast as it will be run on every call
*/

$db = MWG::getDb();
ob_start();
upgrade($db);
$debug = ob_get_clean();
// print "<pre>\n$debug\n"; print_r($db); exit();


function upgrade(mysqldb $db) {

  $tables = $db->get_results("show tables like 'mwg%'");
  if (count($tables) > 0) {
    $db_version = $db->get_value('select value from mwg_setting where name=?', 'site_dbversion');
  } 
  if (! $db_version) {
    $db_version = '1.0';
  }

  if ($db_version < 1.3) {
    $lock = $db->get_value('select value from settings where name=?', 'lock');
    if ($lock > 1) return $db_version;

    if ($lock == 1) {
      $db->query('update settings set value=2 where name=?', 'lock');
    } else {
      $db->query("insert into settings (box_type, name, value) values ('hidden', 'lock', 2)");
    }

    include('upgrade13.php');
    upgrade13($db, $db_version);

    $db->query('update settings set value=1 where name=?', 'lock');
  }

  return $db_version;

}

function run_upgrade($db, $file) {
  $txt = file_get_contents($file);
  $queries = explode(";\n", $txt);
  foreach ($queries as $q) {
    $q = trim($q);
    if ($q) {
      print ".$q.\n";
      $db->query($q);
      print $db->_error;
    }
  }

  return $db->get_value('select value from mwg_setting where name=?', 'site_dbversion');
}

