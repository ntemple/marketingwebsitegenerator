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

class MWG {

  /** @var mwgDocument */
  var $document;
  
  /** @var Template */
  var $template;  // BFM's template system

  /** @var modleTheme */
  var $theme;

  /** @var WMGDataRegistry */
  var $registry;
  
  /** @var mwgRequest */
  var $request;
  
  /** @var mwgResponse */
  var $response;
  
  /** @var mwgSettings */
  var $settings;

  // $this->BASEHREF =  MWG_BASEHREF;

  #  var $theme      = 'computer1';  // The name of the theme
  #  var $theme_type = 'joomla';     // the type of the theme
  var $site_name  = 'Marketing Website Generator';

  private function __construct() {
    $this->request  = new mwgRequest();
    $this->response = new mwgResponse();
    
    $this->registry = mwgDataRegistry::getInstance();    
    $default_theme = $this->registry->get('theme.default', 'bfm', true);

    $this->theme = new modelThemes($default_theme);

    $this->document = new mwgDocument();
    
//    $this->settings = new mwgSettings();
    
    /* Switcher needs to be in a plugin */
    if (isset($_GET['theme'])) {
      $this->theme->switchThemes($_GET['theme']);      
    }  else  {
      if (isset($_COOKIE['theme'])) $this->theme->switchThemes($_COOKIE['theme']);
    }
        
    $this->loadPlugins();
  }

  static function getInstance() {
    static $instance;

    if ($instance) return $instance;

    $instance = new MWG();
    return $instance;
  }
  
  function loadPlugins() {
    // Load ALL the plugins.  
    // @todo make this more efficient
    $plugin_dirs = $this->listDir(MWG_BASE . '/plugins/');
    foreach($plugin_dirs as $ptypes) {
      $this->loadPluginGroup($ptypes);
    }          
  }
  
  function loadPluginGroup($ptype) {
    $plugins = $this->listDir(MWG_BASE . '/plugins/' . $ptype);
    foreach ($plugins as $plugin) {
      $files = $this->listFiles(MWG_BASE . "/plugins/$ptype/$plugin");
      foreach ($files as $file) {
        $ext = explode('.', $file);
        $ext = array_pop($ext);
        if ($ext == 'php') include(MWG_BASE . "/plugins/$ptype/$plugin/$file");
      }
    }
  }

  /**
  * put your comment there...
  * @returns mysqldb $db
  */
  function getDb() {
    static $db;

    if ($db) return $db;

    $db = new mysqldb();
    $db->connect(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
    $db->connect();

    return $db;
  }

  function listFiles($base) {
    $dirs = array();

    if ($handle = opendir($base)) {
      while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != '.svn' && !is_dir("$base/$file") ) {                      
          $dirs[] = $file;
        }
      }
      closedir($handle);
    }
    return $dirs;
  }


  function listDir($base) {
    $dirs = array();

    if ($handle = opendir($base)) {
      while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != '.svn' && is_dir("$base/$file") ) {                      
          $dirs[] = $file;
        }
      }
      closedir($handle);
    }
    return $dirs;
  }
  
  function runEvent($method, $args) {
    if (!class_exists('modelGizmo')) require_once(MWG_BASE . '/components/gizmo/modelgizmo.class.php');
    $model = new modelGizmo();
    $gizmos = $model->getActiveGizmos();
    
    foreach ($gizmos as $gizmo) {
      $func = array($gizmo, $method);
      if (is_callable($func)) {
        call_user_func_array($func, $args);
      }
    }    
  }

  /**
   * @todo: return the search path for the active theme
   */
  function getTemplatePath() {
//    return array('/var/www/html/mwg/script/themes/mwg-default');
    return array();
  }

  function start() {
    $this->runEvent('afterStart', array($this->request, $this->response));
  }

  function end(Template $tpl) {
    if (defined('SITENAME')) $this->site_name = SITENAME;

    $this->template = $tpl;
    $this->document->setDescription($this->tplGet('description'), true);
    $this->document->setKeywords($this->tplGet('keywords'), true);
    $this->document->setTitle(trim($this->tplGet('keywords_title')), false, true);
    $this->document->setTitle($this->site_name, false, true);
    
    $content = $this->theme->process($tpl);

    $this->runEvent('beforeDoShortcode', array($this->document, $content));

    // Apply shortcode filter
    $content = do_shortcode($content); 

    $this->runEvent('beforeDocumentRender', array($this->document, $content));
    // Set the code in the document, and render
    $this->document->setContent($content);
    $page = $this->document->renderDocument();
    $this->runEvent('afterDocumentRender', array($page));
    print $page;
  }


  function getContent($section = 'content') {
    #    $this->template->set_var($section, '{content}');
    $this->template->set_file($section, "$section.html");    

    ob_start();
    $this->template->pparse('out', $section);
    return ob_get_clean();
  }

  /**
  * Return a list of menu items as raw links 
  * or unordered list
  * 
  * @param mixed $type
  */
  
  function getMenu($type = 'list') {
    global $sess_id, $membership_id;

    $db = $this->getDb();

    if (isset($sess_id)) {
      $items = generate_main_menu_list('members', $membership_id);      
    } else {
      $items = generate_main_menu_list('main');      
    }
    
    switch ($type) {
      case 'list':  return _render_menu_list($items); break;
      default:      foreach ($items as $item) {
                      $array[] = _render_link($item);
                    }
                    return $array;
    }
  }

  function tplGet($var) {
    return $this->template->varvals[$var];
  }


  /**
  This should be changed to be page specific. Right now, BFM
  has one title / description / keywords for all pages
  */ 
  /**
  * Get the extra head strings from the document
  * @deprecated 1.1
  * 
  */
  
  function getHead() {
    return '';
//    return $this->document->getHead();
  }
  /**
  * Get the document title
  * @deprecated 1.1
  * 
  */
  
  function getTitle() {
    return $this->document->getTitle();
  }         

}

function mwg_shortcode_gizmo($atts) {
  $id = $atts['id'];
  if (!$id) return;
  
  if (!class_exists('modelGizmo')) require_once(MWG_BASE . '/components/gizmo/modelgizmo.class.php');
  $model = new modelGizmo();
  $gizmos = $model->getActiveGizmos();
  if (!isset($gizmos[$id])) return;
  
  $gizmo = $gizmos[$id];
  
  if ($gizmo) {
    return $gizmo->render($atts);
  }
}
add_shortcode('gizmo', 'mwg_shortcode_gizmo');
