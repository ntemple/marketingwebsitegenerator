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

class modelThemes {
  var $themes     = null;
  var $theme      = 'bfm';     // The name of the theme
  var $themedir;               // calculated directory of theme         
  var $current_theme;
  var $current_theme_href;
  var $current_theme_path;
  var $current_theme_type;

  function __construct($default) {
    $this->theme = $default;
    $this->listThemes();   
  }
    
  function switchThemes($theme) {
    if (isset($this->themes[$theme])) {
      $this->theme = $theme;
      setcookie('theme', $theme); // @todo make a session var
    } else {      
      setcookie('theme', '', -1);
    }
  
  }

  function listDir($base) {
    $dirs = array();

    if ($handle = opendir($base)) {
      while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != '.svn' && is_dir("$base/$file")) {
          $dirs[] = $file;
        }
      }
      closedir($handle);
    }
    return $dirs;
  }

  
    
  function listThemes() {
    if ($this->themes) return $this->themes;
    
    $this->themes = array ('bfm' => 'bfm');
    $base = MWG_BASE . '/themes/';
    
    $dirs = $this->listDir($base);
    foreach ($dirs as $file) {
      if (file_exists("$base/$file/templateDetails.xml")) $this->themes[$file] = 'joomla';
      if (file_exists("$base/$file/screenshot.png"))      $this->themes[$file] ='wordpress';      
    }
    
    return $this->themes;    
  }
  
  function getThemes() {
    $base = MWG_BASE . '/themes';
    $themes = array();    
    foreach ($this->themes as $file => $type) {
      $details = new stdClass();
      $details->id   = $file;
      $details->name = $file;
      $details->type = $type;
      if (file_exists("$base/$file/template_thumbnail.png")) $details->preview = MWG_BASEHREF . "/themes/$file/template_thumbnail.png";
      if (file_exists("$base/$file/screenshot.png"))         $details->preview = MWG_BASEHREF . "/themes/$file/screenshot.png";
      $themes[] = $details;
    }
    return $themes;
  }
  
  function process(Template $tpl, $theme = '') {    
          
    if (! $theme) {
      $theme = $this->theme;
    } 
    
    if (isset($this->themes[$theme])) {
      $theme_type = $this->themes[$theme];
    } else {
      // We can't find the theme, fall back
      $theme = 'bfm';
      $theme_type = 'bfm';
    }

    $this->themedir = MWG_BASE . '/themes/' . $theme;

    $this->current_theme = $theme;
    $this->current_theme_href = MWG_BASEHREF . '/themes/' . $theme;;
    $this->current_theme_path = $this->themedir;
    $this->current_theme_type = $theme_type;
        
    switch($theme_type) {
      case 'wordpress': $out = $this->processWordpress(); break;
      case 'joomla':    $out = $this->processJoomla(); break;
      default:          ob_start();
                        $tpl->pparse("out", "main"); 
                        $out = ob_get_clean();
    }    
   
    return $out;
    
  }

  function processWordpress() {    
    define(TEMPLATEPATH, $this->themedir);
    ob_start();
    
    // handle the theme
    require_once("themes.wordpress.php");
    if (file_exists("{$this->themedir}/page.php"))
      include("{$this->themedir}/page.php");
    else 
      include("{$this->themedir}/index.php");         
    return ob_get_clean();
  }

  /**
  * Joomla! Legacy themes (Mambo)
  */
  function processJoomla() {
    require_once('themes.j10.php');
    ob_start();
    include("{$this->themedir}/index.php");
    $out = ob_get_clean();
    return str_replace('/templates/', '/themes/', $out);
  }

}

