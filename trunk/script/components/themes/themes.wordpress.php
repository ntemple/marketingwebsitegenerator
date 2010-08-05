<?php
/* Wordpress Compatible Functions */

class mwgWP {
  
  var $callbacks;
  var $template_positions;
  
  private function __construct() {
    $this->callbacks = array();
    $this->template_positions = array();    
  }
  
  static function getInstance() {
    static $self = null;
    
    if (!$self) 
      $self = new mwgWP();
    return $self;
  }
  
  function add_callback(wpCallback $cb) {
    $class = get_class($cb);
    
    if (!isset($this->callbacks[$class])) $this->callbacks[$class] = array();
    if (!isset($this->callbacks[$class][$cb->hook_name])) $this->callbacks[$class][$cb->hook_name] = array();      
    
    $this->callbacks[$class][$cb->hook_name][] = $cb;
  }
  
  function runCallback($class, $name, $out) {
    // 'wpAction', 'wp_list_pages', $menu
    if (! isset($callback[$class])) return $out;
    if (! isset($callback[$class][$name])) return $out;
    $events = $this->callbacks[$class][$name];

    if (! $events) return $out;
    //@todo sort by priority
    foreach ($events as $callback){
      $out = $callback->execute($out);
    }
    return $out;
  }
  
  function register_template_position($which, $args) {
    $this->template_positions[$which] = $args;
  }
  
  
}

class wpCallback {
  var $hook_name;
  var $callable;
  var $priority;
  var $args;
  
  function __construct($hook_name, $callable, $priority, $args) {
    $this->hook_name = $hook_name;
    $this->callable  = $callable;
    $this->priority  = $priority;
    $this->args      = $args;
  }  
  
  function  execute($params) {
    return call_user_func($this->callable, $params);    
  }
}

class wpFilter extends wpCallback {}
class wpAction extends wpCallback {}


function add_filter($hook_name, $callable, $priority = 10, $args = null) {
  sbutil::trace();
  mwgWP::getInstance()->add_callback(new wpFilter($hook_name, $callable, $priority, $args));
}

function add_action($hook_name, $callable, $priority = 10, $args = null) {
  sbutil::trace();
  mwgWP::getInstance()->add_callback(new wpAction($hook_name, $callable, $priority, $args));
}

if (! function_exists('remove_action')) {
function remove_action() {
  sbutil::trace();
}}

/*
if (function_exists('register_sidebars')) {
  register_sidebars(3, array(
    'before_widget' => '<!--- BEGIN Widget --->',
    'before_title' => '<!--- BEGIN WidgetTitle --->',
    'after_title' => '<!--- END WidgetTitle --->',
    'after_widget' => '<!--- END Widget --->'
  ));
}
*/

/**
* http://codex.wordpress.org/Function_Reference/dynamic_sidebar
* 
* @param mixed $which
*/

function dynamic_sidebar($which = 1) {
  sbutil::trace();
  $name = 'Sidebar' . $which;

  $args = mwgWP::getInstance()->template_positions['Sidebar'.$which];
  $out = MWG::getTheme()->renderGizmos($name, $args);
  print $out;
  return true;
}

/** sidebars, menu positions */

/**
* http://codex.wordpress.org/Function_Reference/register_sidebars
* 
* @param mixed $number
* @param mixed $args
*/

function register_sidebars($number, $args = array()) {
 
for ($i = 1; $i <= $number; $i++) {
 
$defaults = array(
  'name'          => "Sidebar $i",
  'id'            => "sidebar-$i",
  'before_widget' => "<li class='widget'>",
  'after_widget'  => '</li>',
  'before_title'  => '<h2 class="widgettitle">',
  'after_title'   => '</h2>' 
  ); 
  
  $params = array_merge($defaults, $args);
    
    mwgWP::getInstance()->register_template_position("Sidebar$i", $params);        
  }
 
}

/**
* http://codex.wordpress.org/Function_Reference/register_sidebar
* 
* @param mixed $params
*/
function register_sidebar($args) {
  register_sidebars(1, $args);
}
/*
{  
  $defaults = array(
  'name'          => sprintf(__('Sidebar %d'), $i ),
  'id'            => 'sidebar-$i',
  'description'   => '',
  'before_widget' => '<li id="%1$s" class="widget %2$s">',
  'after_widget'  => '</li>',
  'before_title'  => '<h2 class="widgettitle">',
  'after_title'   => '</h2>' ); 
  
  $params = array_merge($defaults, $args);
  
  mwgWP::getInstance()->register_template_position($params['name'], $params);  
}
*/
  

function add_custom_background(){
  sbutil::trace();
}

function wp_tag_cloud() {
  sbutil::trace();
}

function is_archive() {
  sbutil::trace();
}

function get_the_excerpt() {
  sbutil::trace();
}


function single_post_title() {
  sbutil::trace();
}

function load_theme_textdomain() {
  sbutil::trace();
}

function the_search_query() {
  sbutil::trace();
}

function current_user_can() {
  sbutil::trace();
}

function get_calendar() {
  sbutil::trace();
}


function automatic_feed_links() {
  sbutil::trace();
}

function language_attributes() {
  sbutil::trace();
}

function is_single() {
  sbutil::trace();
  return true;
}

function is_singular() {
  sbutil::trace();
  return true;
}

function wp_enqueue_script() {
  sbutil::trace();
}

function get_option($name) {  
  sbutil::trace();
  
  if ($name == 'home') {  
    $homelink = null;
    $menu = MWG::getInstance()->getMenu('items');
    $home = array_shift($menu);
    return $home['link'];
  }
}


function get_avatar() {
   sbutil::trace();
}

function is_tag() {
  sbutil::trace();
}

function bloginfo($var = 'name') {
  print get_bloginfo($var);
}


function get_settings($var) {
  return get_bloginfo($var);
}

function get_bloginfo($var = 'name') {
  global $wp_info;

  $mwg = MWG::getInstance();
  $assets = $mwg->theme->current_theme_href;

  // capture variables so we know what
  // the template is looking for during
  // development
  if (isset($wp_info[$var])) {
    $out = ($wp_info[$var]);
  } else {
    $out = '';
  }

  // Offer up some default content
  // @todo implement all: http://codex.wordpress.org/Function_Reference/get_bloginfo

  switch($var) {
    case 'html_type':            $out = ''; break;
    case 'charset':              $out = ''; break;
    case 'body_class':           $out = 'blog'; break;
    case 'name':                 $out = $mwg->get_setting('site_name'); break;
    case 'description':          $out = $mwg->get_setting('theme_subtitle');  break;
    case 'stylesheet_url':       $out = "$assets/style.css"; break;
    case 'stylesheet_directory': $out = $assets; break;

    case 'url':
    case 'siteurl':
    case 'home':                 $out = MWG_BASEHREF; break;
    case 'template_url':         $out = $assets; break;
   
    case 'pingback_url': 
    case 'rss2_url': 
    case 'comments_rss2_url': 
    default: $out = '';
  }
  
  $wp_info[$var] = $out;
  
  return $out;
}

function wp_title() {
  sbutil::trace();

  $mwg = MWG::getInstance();
  $title = $mwg->getTitle();
  print $title;
}


function wp_get_archives() {
  sbutil::trace();
}


function wp_head() {
  $mwg = MWG::getInstance();
  print $mwg->getHead();
}

function body_class() {
  # sbutil::trace();
  print 'class="blog"';
}


function get_num_queries() {
  sbutil::trace();
}


function timer_stop() {
  sbutil::trace();
}

/**
 * Localization functions 
 */
function __($msg) {
  return $msg;
}

function _e($msg, $domain = 'default') {
  return $msg;
}

function esc_attr_e($msg) {
  return htmlentities($msg);
}


function wp_footer() {
  sbutil::trace();
}

function get_search_form() {
  sbutil::trace();
}

function get_posts() {
  sbutil::trace();
}

function next_posts_link() {
  sbutil::trace();
}

function previous_posts_link() {
  sbutil::trace();
}

function is_404() {
  sbutil::trace();
  return false;
}

function is_category() {
  sbutil::trace();
  return false;
}

function is_day() {
  sbutil::trace();
  return false;
}

function is_month() {
  sbutil::trace();
  return false;
}

function is_year() {
  sbutil::trace();
  return false;
}

function is_search() {
  sbutil::trace();
  return false;
}


function is_paged() {
  sbutil::trace();
  return false;
}

function is_home() {
  sbutil::trace();
  return false;
}

function is_page() {
  sbutil::trace();
  return true;
}


// seems wordpress has an off-by one error?
function have_posts() {
  sbutil::trace();
  $mwg = MWG::getInstance();

  // We have 1 post, and that's the content
  // unless we are told otherwise
  if (isset($mwg->posts)) {
    $posts = $mwg->posts;
  } else {
   $posts = 2;
  }


  if ($posts > 0) {
    $mwg->posts = $posts -1;
#    print $mwg->getContent();
    return true;
  } else {
    return false;
  }
}

function the_post() {
  sbutil::trace();
#  $mwg = MWG::getInstance();
#  print $mwg->getContent();
}

function post_class() {
  sbutil::trace();
  print "class='entry'";
}

function the_ID() {
  sbutil::trace();
  print $mwg->posts;
}

function the_permalink() {
  sbutil::trace();
}

function the_title($before = '', $after = '', $echo = true) {
 sbutil::trace();
}

function the_title_attribute() {
  sbutil::trace();
}

function the_category() {
  sbutil::trace();
}

function the_tags() {
  sbutil::trace();
}

function the_author() {
  sbutil::trace();
}

function the_time() {
  sbutil::trace();
}

function edit_post_link() {
  sbutil::trace();
}

function the_content($more_link_text = null, $stripteaser = 0) {
  sbutil::trace();
  print get_the_content($more_link_text, $stripteaser);
}

function get_the_content($more_link_text = null, $stripteaser = 0) {
  sbutil::trace();
  $mwg = MWG::getInstance();
  return $mwg->getContent();
}


function the_date() {
  sbutil::trace();
}

function wp_link_pages() {
  sbutil::trace();
}

function link_pages($before, $after) {
  sbutil::trace();
}

function query_posts($params) {
  sbutil::trace();
}

function get_links_list() {
  sbutil::trace();
}

function wp_list_cats() {
  sbutil::trace();
}

function posts_nav_link() {
  sbutil::trace();
}

function comments_popup_link() {
  sbutil::trace();
}

function comments_template() {
  sbutil::trace();
}

function wp_list_pages($args) {
  sbutil::trace();
  
  $default =  array(
    'depth'        => 0,
    'show_date'    => '',
    'date_format'  => get_option('date_format'),
    'child_of'     => 0,
    'exclude'      => '',
    'include'      => '',
    'title_li'     => '', //__('Pages'),
    'echo'         => 1,
    'authors'      => '',
    'sort_column'  => 'menu_order, post_title',
    'link_before'  => '',
    'link_after'   => '',
    'exclude_tree' => '',);
  
  
  $mwg = MWG::getInstance();
  $items = $mwg->getMenu('array'); // Forces removal of wp link
  array_shift($items); // Remove 'Home' link

  $menu = '';
  foreach ($items as $item) {
    $menu .= "<li>$item</li>\n";
  }  
  $menu = mwgWP::getInstance()->runCallback('wpAction', 'wp_list_pages', $menu);  
  print $menu;
}

function wp_list_bookmarks() {
  sbutil::trace();
}

function wp_list_categories() {
  sbutil::trace();
}

function wp_register() {
  sbutil::trace();
}

function wp_loginout() {
  sbutil::trace();
}

function wp_meta() {
  sbutil::trace();
}


function get_sidebar() {
  sbutil::trace();
  mwg_wp_find_template('sidebar');
}

function get_header($name = null) {
  mwg_wp_find_template('header', $name);
}

function get_footer($name = null) {
  mwg_wp_find_template('footer', $name);
}


// Private Support functions. Better in a class?

function mwg_wp_find_template($type, $name = null) {
#  do_action('get_' . $type, $name );

  $mwg = MWG::getInstance();
  $themedir = $mwg->theme->current_theme_path;
 
   $templates = array();
   if (isset($name)) {
     $templates[] = "$themedir/{$type}-{$name}.php";
   }
   $templates[]   = "$themedir/{$type}.php";
   $templates[]   = dirname($themedir) . "/default/{$type}.php";


   foreach ($templates as $template) {
     if (file_exists($template)) {
       mwg_wp_load_template($template);       
       break;
     }
   }
}



function mwg_wp_load_template($path) {
#        global $posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

#        if ( is_array($wp_query->query_vars) )
#                extract($wp_query->query_vars, EXTR_SKIP);
// print "<b>LOADING: $path</b><br>\n";
        require_once($path);
}

// @todo implement generic search features
//  if (defined('MWG_HAS_SEARCH')) (show search form with "s" as query)
//

