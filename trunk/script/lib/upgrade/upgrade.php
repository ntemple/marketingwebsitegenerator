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
upgrade($db);

function upgrade(mysqldb $db) {
  $cols = $db->get_results('show columns from mwg_setting');
  if (count($cols) > 0) {
    $db_version = $db->get_value('select value from mwg_setting where name=?', 'site_dbversion');
  } else {
    $db_version = '1.0';
  }
  if ($db_version == '1.0') {
    $queries = @file(MWG_BASE . '/lib/upgrade/upgrade-1.0.txt');
    foreach ($queries as $q) {
      if ($q) $db->query($q);
    }
    $db_version = $db->get_value('select value from mwg_setting where name=?', 'site_dbversion');
  }
  
  return $db_version;
}

