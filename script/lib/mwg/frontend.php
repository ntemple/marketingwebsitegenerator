<?php
// MWG frontend library hooks
/**
The main MWG class.  Here to protect ourself from
global variables pervasive throughout the script.
requires PHP 5.
*/
require_once('includes/sbutil.class.php');
require_once('includes/mysqldb.class.php');
require_once('mwgregistry.class.php');
require_once(MWG_BASE . '/components/themes/modelthemes.class.php');

// Plugins - we need a plugin manager
require_once('shortcodes.php');
$plugins = array(
'utech-spinning-earth/spinning-earth.php',
'mwg-shortcodes/mwg-shortcodes.php'
);

sbutil::$LOG = false;
sbutil::initLogging(MWG_BASE . '/tmp/app.log');
sbutil::debug('START');
sbutil::$print_trace = false;

class MWG {

  /** @var Template */
  var $template;  // BFM's template system

  /** @var msyqldb **/
  var $db;  // Our connection to the database

  /** @var modleTheme */
  var $theme;

  /** @var BMGenRegistry */
  var $registry;

  // $this->BASEHREF =  MWG_BASEHREF;

  #  var $theme      = 'computer1';  // The name of the theme
  #  var $theme_type = 'joomla';     // the type of the theme
  var $site_name  = 'Marketing Website Generator';

  private function __construct() {
    $this->registry = BMGenRegistry::getInstance();
    $default_theme = $this->registry->get('theme.default', 'bfm', true);

    $this->theme = new modelThemes($default_theme);

    /* Switcher needs to be in a plugin */
    if (isset($_GET['theme'])) {
      $this->theme->switchThemes($_GET['theme']);      
    }  else  {
      if (isset($_COOKIE['theme'])) $this->theme->switchThemes($_COOKIE['theme']);
    }

    // Load ALL the plugins.  
    // @todo make this more efficient
    $plugins[] = array();    
    $plugin_dirs = $this->listDir(MWG_BASE . '/plugins/');
    foreach($plugin_dirs as $ptypes) {
      $this->loadPluginGroup($ptypes);
    }  
  }

  static function getInstance() {
    static $instance;

    if ($instance) return $instance;

    $instance = new MWG();
    return $instance;
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

  function getDb() {
    static $db;
    global $q;

    if ($db) return $db;

    $db = new  mysqldb();
    $db->setDBH($q->link_id()); 
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



  function start() {
  }

  function end(Template $tpl) {

    $this->template = $tpl;
    if (defined('SITENAME')) $this->site_name = SITENAME;

    $content = $this->theme->process($tpl);

    // Apply shortcode filter
    $content = do_shortcode($content); 
    print $content;
  }


  function getContent($section = 'content') {
    #    $this->template->set_var($section, '{content}');
    $this->template->set_file($section, "$section.html");    

    ob_start();
    $this->template->pparse('out', $section);
    return ob_get_clean();
  }

  // MWG NLT TODO:
  // IMPORTANT: This must be rebuilt based on the functions in
  // inc.functions.php in order to preserve the integrity of
  // the system. 
  function getMenu($type = 'list') {
    global $sess_id, $membership_id;

    $db = $this->getDb();

    if (isset($sess_id)) {
      $items = generate_main_menu_list('members', $membership_id);      
    } else {
      $items = generate_main_menu_list('main');      
    }
    
    $list = _render_menu_list($items);
/*
    $mitems = $db->get_results('select * from menus where menu_category=? and active=1
    order by position asc, id asc', $category, 1);
    #    print_r($mitems);
    $out = '';
    foreach ($mitems as $item) {
      $link = "<a href='{$item[link]}'>{$item[name]}</a>";
      $list .= "  <li>$link</li>\n";
      $array[] = $link;
    }
    $list = "<ul>\n$list</ul>\n";
*/
    switch ($type) {
      case 'list': print $list; break;
      default: return $array;
    }
  }


  /**
  This should be changed to be page specific. Right now, BFM
  has one title / description / keywords for all pages
  */ 
  function getHead() {
    $description = $this->tplGet('description');
    $keywords    = $this->tplGet('keywords');

    $out = "
    <meta name='description' content='{$description}' />
    <meta name='keywords' content='{$keywords}' />
    <xlink href='css/butterfly.css' rel='stylesheet' type='text/css' />
    <script language='JavaScript' src='js/functions.js'></script>
    ";
    return $out;

  }

  function getTitle() {
    $title =  trim($this->tplGet('keywords_title'));
    if (! $title) $title = $this->site_name;
    return $title;
  }


  function tplGet($var) {
    return $this->template->varvals[$var];
  }

}
/*
// Plugin functions, theme independent
function add_filter($type, $method, $order) {
global $filters;

$event = array(
'method'  => $method,
'ordre'   => $order
);

$filters[$type] = $event;
}

function trigger_filter($type, $args) {
global $filters;

foreach ($filters[$type] as $event) {
call_user_func_array($event['method'], $args);
}
}
*/


function plugin_basename($file) {

  $file = str_replace('\\','/',$file); // sanitize for Win32 installs
  $file = preg_replace('|/+|','/', $file); // remove any duplicate slash
  $plugin_dir = str_replace('\\','/',WP_PLUGIN_DIR); // sanitize for Win32 installs
  $plugin_dir = preg_replace('|/+|','/', $plugin_dir); // remove any duplicate slash
  $mu_plugin_dir = str_replace('\\','/',WPMU_PLUGIN_DIR); // sanitize for Win32 installs
  $mu_plugin_dir = preg_replace('|/+|','/', $mu_plugin_dir); // remove any duplicate slash
  $file = preg_replace('#^' . preg_quote($plugin_dir, '#') . '/|^' . preg_quote($mu_plugin_dir, '#') . '/#','',$file); // get relative path from plugins dir
  $file = trim($file, '/');
  return $file;
}

