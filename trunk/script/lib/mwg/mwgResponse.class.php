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

require_once('context.class.php');

class mwgResponse extends Context {

  var $_head;
  var $_success = null;
 
  function __construct() {
     parent::__construct(MWG_ADMIN . '/themes/default/', MWG_BASE . '/tmp/tcache/');

    // Necessary constants
    $this->MWG_BASEHREF = MWG_BASEHREF;
  }

  function includeHeaderFile($file) {
   $this->_head .= $this->getOutput($file);
  }

  function addHeader($text) {
    $this->_head .= "\n$text\n";
  }

  function newContext() {
     return clone($this);
  }

  function setFlash($message, $type = 'info') {
    $_SESSION['flash'] = array( 
      'message' => $message,
      'level'   => $type
    );
  }

  function getFlash() {
     if (isset($_SESSION['flash'])) {
       $this->message = $_SESSION['flash']['message'];
       $this->level   = $_SESSION['flash']['level'];
       unset($_SESSION['flash']);
     }
  }
    
  function route($module, $action='default', $data= '') {
      $location = "servlet.php?m=$module&a=$action&$data";
      $this->redirect($location);
  }

  function redirect($path, $message = '', $type = info) {
    if ($message) {
      $this->setFlash($message, $type);
    }

    header("Location: $path");
    exit(0);
  }


  function marshall() {
       require_once('includes/IXR_Library.inc.php');

       $result = clone($this);
       unset($result->opt);
       unset($result->_head);
       unset($result->_template);
       unset($result->elements);
      // TODO: unset all _ (private) vars;
      $r = new IXR_Value($result);
      return $r->getXml();
  }

}



