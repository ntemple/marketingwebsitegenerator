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

class mwgRequest {
  
  var $req;
  
  function __construct($req = null) {
    $this->req = $req;
    if (! $this->req) {
      $this->req = $_REQUEST;
    }    
/*    
    print "<pre>\n";
    print_r($_GET);
    print_r($_POST);
    print_r($_REQUEST);
    print "</pre>\n";
*/    
    
  }

//  function isPost() { return true; }
// function isGet()  { return true; }
  
  function get($name, $default = null) {
    if (isset($this->req[$name])) return $this->req[$name];
    return $default;
  }
  
}




