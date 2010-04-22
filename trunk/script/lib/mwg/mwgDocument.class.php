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

// Encapsulate a document (single page)

class mwgDocument {

  var $head;            // array of extra headers
  var $title;           // current title
  var $meta_descripton; // current description
  var $meta_keywords;   // keywords
  var $before_body_end; // code to add before the body end

  var $template;

  function __construct() {
    $this->head = array();
    $this->before_body_end = array();
    $this->addJs(MWG_BASEHREF . '/js/functions.js');
  }

  function setDefaultDescription($description) {
    if (!$this->meta_descripton) {
      $this->meta_descripton = $description;
    }        
  }
  
  function setDefaultTitle($title) {
    if (! $this->title) {
      $this->title = $title;
    }
  }
  
  function setDefaultKeywords($keywords) {
    if (!$this->meta_keywords) {
      $this->meta_keywords = $keywords;
    }
  }
  
  function addToHead($string) {
    $this->head[] = $string;
  }
  
  function addJs($path) {
    $this->head[] = "<script src='$path' type='text/javascript'></script>";
  }
  
  function addCSS($path) {
    $this->head[] = "<link rel='stylesheet' href='$path' type='text/css' />";    
  }
  
  function addBeforeBodyEnd($string) {
    $this->before_body_end[] = $string;
  }
  
  /**
  This should be changed to be page specific. Right now, BFM
  has one title / description / keywords for all pages
  */ 
  function getHead() {
    if ($this->keywords)    array_unshift($this->head, "<meta name='keywords' content='{$this->description}' />");
    if ($this->description) array_unshift($this->head, "<meta name='description' content='{$this->description}' />");
    $out .= "";

    foreach ($this->head as $string) {
      $out .= "    $string\n";
    }
    return "\n$out\n";
  }

  function getTitle() {
    return $this->title;
  }
  
  function setContent($content) {
    $this->content = $content;
  }
  
  /**
  * Last function to be called.
  * Completes regex replacement, 
  * and prints the document
  * 
  */
  function renderDocument() {
    
    $newbody = implode("\n", $this->before_body_end ) . "</body>";
    $content = str_ireplace('</body>', $newbody, $this->content);
    
    $head = $this->getHead();
    $content = str_ireplace('</head>', "$head</head>", $content);

    return $content;
  }
  
}

