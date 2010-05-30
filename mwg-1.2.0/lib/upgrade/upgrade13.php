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

function upgrade13($db, $db_version) {

  # Upgrade members table
  $cols = $db->get_results('show columns from members');

  $admin = false;

  # Members Table
  foreach ($cols as $field) {
    switch ($field['Field']) {
      case 'stormpay_email':    $db->query('alter table members drop stormpay_email'); break;
      case 'p_stormpay_email':  $db->query('alter table members drop p_stormpay_email'); break;
      case 'admin': $admin = true;
    }
  }
  if (! $admin) $db->query("ALTER TABLE `members` ADD `admin` CHAR( 1 ) NOT NULL DEFAULT '0' AFTER `jv`");


  $tables = $db->get_results("show tables like 'mwg_setting'");
  if (count($tables) == 0) {
     run_upgrade($db, MWG_BASE . '/lib/upgrade/table.setting.txt');
  }

 $tables = $db->get_results("show tables like 'mwg_gizmo'");
  if (count($tables) == 0) {
     run_upgrade($db, MWG_BASE . '/lib/upgrade/table.gizmo.txt');
  }

  $db_version = $db->get_value('select value from mwg_setting where name=?', 'site_dbversion');
  if (! $db_version) run_upgrade($db, MWG_BASE . '/lib/upgrade/table.settings.data.txt');
  $db_version = $db->get_value('select value from mwg_setting where name=?', 'site_dbversion');


  $db_version = run_upgrade($db, MWG_BASE . '/lib/upgrade/upgrade-1.1.txt');

  # Add the subtitle
  if (! $db->get_value('select id from mwg_setting where name=?', 'theme_subtitle')) 
  $db->query("INSERT INTO `mwg_setting` (`id` ,`category` ,`group` ,`name` ,`value` ,`default_value` ,`input_type` ,`label` ,`help_text` ,`options` ,`rank`)VALUES (NULL , 'Global Site Settings', NULL , 'theme_subtitle', 'Just Another Marketing Website Generator Site', '', 'input', 'Site Subtitle', 'Some themes (wordpress) have the option to use a subtitle. Enter that here.', '', '0')");


  $db_version = run_upgrade($db, MWG_BASE . '/lib/upgrade/upgrade-1.2.txt');

  $db->query("UPDATE mwg_setting SET value='1.3' WHERE name = 'site_dbversion'");
  $db_version = $db->get_value('select value from mwg_setting where name=?', 'site_dbversion'); 

  return $db_version;
}


