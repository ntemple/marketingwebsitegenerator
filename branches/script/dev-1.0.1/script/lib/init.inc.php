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

define('_MWG', true);
define('_SB_VALID_', true);

define('MWG_BASE',   dirname(dirname(__FILE__)));
define('MWG_ADMIN',  MWG_BASE . '/admin');
define('MWG_LIB',    MWG_BASE . '/lib');
define('GENSTALL_BASEPATH', MWG_BASE);
define('GENSTALL_BFPATH', MWG_BASE);


// @todo remove all references to the genstaller patch (code now in core)

// Find basehref for self-referencing URL's
$parts = split('/', $_SERVER['SCRIPT_NAME']);

$self = array_pop($parts);
$admin = array_pop($parts);
if ($admin == 'admin') {
  define('GENSTALL_BE', true);
  define('GENSTALL_FE', false);  
} else {
  define('GENSTALL_BE', false);
  define('GENSTALL_FE', true);
  array_push($parts, $admin);     
}

$href = implode('/', $parts);

define('MWG_BASEHREF', 'http://' . $_SERVER["HTTP_HOST"] . $href);
define('GENSTALL_URLROOT', MWG_BASEHREF);
define('WP_PLUGIN_DIR', MWG_BASE . '/plugins');
define('WP_PLUGIN_URL', MWG_BASEHREF . '/plugins');


/*
* Determine seperators
*/
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
  $incsep = ';'; // Windows
  $pathsep = '\\';
} else {
  $incsep  = ':'; // default for linux
  $pathsep = '/';
}
define('DS', $pathsep);
define('IS', $incsep);


/*
* Set includes to find libs
*/

$path  = ini_get('include_path');
$path  = $path . IS . MWG_LIB; 
ini_set('include_path', $path);

/*
* Dump magic_quotes
*/

set_magic_quotes_runtime(0);
if( get_magic_quotes_gpc() ) {
  stripslashes_deep($_GET);
  stripslashes_deep($_POST);
  stripslashes_deep($_COOKIE);
  stripslashes_deep($_REQUEST);
}

function stripslashes_deep($value) {
  $value = is_array($value) ? array_map("stripslashes_deep", $value) : stripslashes($value);
  return $value;
}
require_once('mwg/frontend.php');

