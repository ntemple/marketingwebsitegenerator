<?php
// Joomla legacy templates
define( '_VALID_MOS', true );

/* Globals */
$mwg = MWG::getInstance();

global $mainframe;
global $my;
global $mosConfig_live_site;
global $cur_template;
global $sitename; // Todo: lookup
global $mosConfig_sitename;

$mosConfig_live_site = MWG_BASEHREF;
$cur_template        = $mwg->theme->current_theme;
$sitename            = $mwg->site_name;
$mosConfig_sitename  = $sitename;

if (!defined('_ISO')) DEFINE('_ISO','charset=iso-8859-1');

function mosShowHead() {
  $mwg = MWG::getInstance(); 
  $title = $mwg->getTitle();
  print "        <title>$title</title>\n";
  print $mwg->getHead();
}

function mosPathWay() {
}

function mosLoadModules($position, $display_type = '') {  
  print MWG::getTheme()->renderGizmos($position, array()) ;
}

function mosCountModules($position) {
  return MWG::getTheme()->countGizmos($position);
}

function mosMainBody() {
  $mwg = MWG::getInstance();
  print $mwg->getContent();
}

function mosMainMenu() {
  $mwg = MWG::getInstance();
  print $mwg->getContent('menu');
}


class MOS {
  function getCfg($var) {    
    return (isset($GLOBALS[$var])) ?$GLOBALS[$var] : '';
  }  
}

class mwgMOSUser {
  var $id = 0;
}

function mosCurrentDate() {
}

function mosLoadComponent() {
}

$my = new mwgMOSUser();
$mainframe = new MOS();

