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

class modelGizmo {

   static $gizmos;

  /**
  * Factory method to create a Gizmo
  * 
  * @todo: Refactor to a generic factory class based on identity
  * 
  * @param mixed $identity  the identity of the gizmo
  * @param mixed $gizmo_mf  optional manifest, if we have it
  * @returns mwgBaseGizmo $gizmo The gizmo class
  */
  function gizmoFactory($identity, $gizmo_mf = null) {

    $ident = explode('.', $identity);
    $mwg = array_shift($ident);
    if ($mwg != 'mwg') return false;

    $path = $ident;
    array_unshift($path, MWG_BASE);
    $path = implode('/', $path);   
    $class = array_pop($ident);

    if (!class_exists($class))require_once("$path.class.php");

    $gizmo = new $class($identity);
    if ($gizmo_mf) {
      $gizmo->setManifest($gizmo_mf);
    }
    return $gizmo;    
  }

  /**
  * @param mixed $id
  * @return mwgBaseGizmo
  */
  function instantiate($id) {
    $gizmo = null;
    $db = MWG::getInstance()->getDb();
    $row = $db->get_row('select * from mwg_gizmo where id=? and active=1 limit 1', $id);

    if ($row) $gizmo = $this->gizmoFactory($row['identity']);
    if ($gizmo) $gizmo->hydrate($row);
    return $gizmo;
  }

  function getActiveGizmos() {
    if (self::$gizmos) return self::$gizmos;
    self::$gizmos = array();
    
    $db = MWG::getInstance()->getDb();
    $model = new modelGizmo();
    
    $gizmo_ids = $db->get_column('select id from mwg_gizmo where active=1');
    foreach ($gizmo_ids as $id) {
      self::$gizmos[$id] = $model->instantiate($id);
    }
    
    return self::$gizmos;
  }

  function getGizmosFor($position) {
    $db = MWG::getInstance()->getDb();
    $gizmos = array();
    
    $gizmo_ids = $db->get_column('select id from mwg_gizmo where active=1 and position=? order by ordre', $position);
    foreach ($gizmo_ids as $id) {
      $gizmos[$id] = $this->instantiate($id);
    }    
    return $gizmos;
  }
  
  
  /**
  * A Gizmo constists of at least two files:
  * - the [name]Gizmo.class.php and the 
  * - [name]Gizmo.yml.php file
  * Optionally, it may have a subdirectory, [name]
  * 
  */

  function listGizmos() {
    $gizmos_mf = array();
    $base = MWG_BASE . '/gizmos';

    if ($handle = opendir($base)) {
      while (false !== ($file = readdir($handle))) {
        if (!is_dir("$base/$file") && strpos($file, 'Gizmo.class.php') > 0) { 
          $ymlfile = str_replace('class.php', 'yml.php', $file);
          if (file_exists("$base/$ymlfile")) {            
            $gizmo_mf = Spyc::YAMLLoad("$base/$ymlfile");               
            $gizmo_identity = $gizmo_mf['identity'];
            if ($gizmo_identity) {
              $gizmos_mf[$gizmo_identity] = $gizmo_mf;             
            }
          }
        }
      }
      closedir($handle);
    }
    /*
    * We know we have a properly formatted gizmo. 
    * What we don't know is if the PHP gizmo file
    * is valid or not. 
    * Loading an invalid file could break the system.
    * Maybe we should have a "Safe Mode?"
    */
    return $gizmos_mf;
  }

}

