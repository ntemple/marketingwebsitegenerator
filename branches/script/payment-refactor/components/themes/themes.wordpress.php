<?php
/* Wordpress Compatible Functions */

function dynamic_sidebar($which = 1) {
  sbutil::trace();
  if ($which == 1) return true;
  else return false;
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

function get_option() {
  sbutil::trace();
}


function bloginfo($var) {
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
  switch($var) {
    case 'html_type':            $out = ''; break;
    case 'charset':              $out = ''; break;
    case 'body_class':           $out = 'blog'; break;
    case 'name':                 $out = $mwg->site_name; break;
    case 'description':          $out = 'Just Another Marketing Website Generator Site'; break;
    case 'stylesheet_url':       $out = "$assets/style.css"; break;
    case 'stylesheet_directory': $out = $assets; break;
    case 'pingback_url':         break;
    case 'home':                 $out = MWG_BASEHREF; 
    case 'url';                  break;
    case 'rss2_url': 
    case 'comments_rss2_url': 
    default: $out = '';
  }
  
  $wp_info[$var] = $out;
  if ($out) print $out;
#  else print "-$var-";
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

function wp_list_pages() {
  sbutil::trace();
  $mwg = MWG::getInstance();
  print $mwg->getMenu('list');
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
  mwg_wp_find_template('sidebar', $name);
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

