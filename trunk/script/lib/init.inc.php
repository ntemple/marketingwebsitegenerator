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
require_once('mwg/frontend.php');     // Provide MWG singleton
require_once('mail.class.php');       // Provide Mail
require_once('isnclient/spyc.php');   // Provide core YML parsing

/**
* We really need to get the register globals taken care of 
*/
function unregister_globals()
{
  $register_globals = @ini_get('register_globals');
  if ($register_globals === "" || $register_globals === "0" || strtolower($register_globals) === "off"){return;}

  if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) die(); // {die() /* exit('It\'s not going to be so easy hacker!!'); */}
  $no_unset = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');

  $input = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
  foreach ($input as $k => $v)
  {
    if (!in_array($k, $no_unset) && isset($GLOBALS[$k]))
    {
      unset($GLOBALS[$k]);
      unset($GLOBALS[$k]);    // Double unset to circumvent the zend_hash_del_key_or_index hole in PHP <4.4.3 and <5.1.4
    }
  }
}

