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


defined('_MWG') or die ('Restricted Access');


/**
* base class for gizmos.
*/
class mwgBaseGizmo {

  /** @var MWG */
  var $mwg;  
  var $identity;
  var $gizmo_mf;

  var $id;
  var $name;
  var $title;
  var $params; 
  var $data;
  var $active;

  
  /**
  * Constructor called with serialized
  * paramaters
  * 
  * @param mixed $params
  * @return mwgGizmoBase
  */
  function __construct($identity)  {
    $this->identity = $identity;
    $this->id = '';
    if ($gizmo_mf) {
      $this->gizmo_mf = $gizmo_mf;
    }    
  }
  
  
  // Override the below methods to add functionality
  
  function getAdminForm($params) {   }

  function extractAdminFormData($request) { }

  /**
  * The main routine to display the gizmo.
  * 
  * In addition to the atts,
  * $this->params contans the params from the admin form
  * 
  * You can use 
  *   $this->saveLocalData to serialize an array for later retrieval
  * and 
  *   $this->getLocalData to get it back later.
  * 
  * @param mixed $atts shortcode style attributes if called via [gizmo id="x"]
  */

  function render($atts) {  }

  
  // Events to overide
  // Commented out for performance
//  function beforeDoShortcode($document, &$content) {  
//    print "beforeDoShortcode ({$this->id})\n";    
//  }

//  function beforeDocumentRender($document, &$content) {  
//    print "beforeDocumentRender ({$this->id})\n";
//  }

//  function afterDocumentRender(&$page) {  
//    print "afterDocumentRender({$this->id})\n";
//  }

  
  
  // Implementation. You should not need to override
  // the following methods.

  function getManifest() {
    if ($this->gizmo_mf) return $this->gizmo_mf;

    $ident = explode('.', $this->identity);
    $mwg = array_shift($ident);
    if ($mwg != 'mwg') return false;

    $path = $ident;
    array_unshift($path, MWG_BASE);
    $path = implode('/', $path) . '.yml.php';
    $this->gizmo_mf = SPYC::YAMLLoad($path);
    return $this->gizmo_mf;
  }

  function setManifest($gizmo_mf) {
    $this->gizmo_mf = $gizmo_mf;    
  }

  function hydrate($row = null) {
    if ($row) {
      foreach ($row as $name=>$value) {
        $this->$name = $value;
      }
      if ($this->params) $this->params = unserialize($this->params);
      if ($this->data) $this->data = unserialize($this->data);
    } else {
      // set defaults
      $gizmo_mf      = $this->getManifest();
      $this->name   = $gizmo_mf['name'];
      $this->title  = $gizmo_mf['title'];
      $this->active = 0;
    }
    
    return $this;
  }

  function store() {
    $row = get_object_vars($this);

    // Don't update the local data unless it has been set
    if ($row['data'])   
      $row['data'] = serialize($row['data']);
    else 
      unset($row['data']);

    if ($row['params']) $row['params'] = serialize($row['params']);
    if (! $row['id']) unset($row['id']);

    $db = MWG::getInstance()->getDb();
    $this->id = $db->store('mwg_gizmo', $row);
    return $this;
  }
  
  function getDocumentation() {
    $mf = $this->getManifest();
    return $mf['documentation'];    
  }
  
  function getLocalData() { 
     return $this->data; 
  }
  
  function saveLocalData($data) {
    $this->data = $data;
    $row = array (
      'id' => $this->id,
      'data' => serialize($data)
    );
    MWG::getInstance()->getDb()->update('mwg_gizmos', $row);
  }

}




