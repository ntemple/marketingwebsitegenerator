<?php
// Joomla legacy templates
define( '_VALID_MOS', true );

/* Globals */
$mwg = MWG::getInstance();

global $mainframe;
global $mosConfig_live_site;
global $cur_template;
global $sitename; // Todo: lookup

$mosConfig_live_site = MWG_BASEHREF;
$cur_template        = $mwg->theme->current_theme;
$sitename            = $mwg->site_name;

function mosShowHead() {
  $mwg = MWG::getInstance(); 
  $title = $mwg->getTitle();
  print "        <title>$title</title>\n";
  print $mwg->getHead();
}

function mosPathWay() {
}

function mosLoadModules() {

}

function mosCountModules() {
  return 0;

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
    return $GLOBALS[$var];
  }
  
}

function mosCurrentDate() {
}

function mosLoadComponent() {
}


$mainframe = new MOS();

