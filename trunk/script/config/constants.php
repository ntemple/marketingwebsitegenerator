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

// This file contains constants
// Database connection constants
define("DB_HOST", "localhost"); // database host
define("DB_NAME", "mwg_script"); // database name
define("DB_USER", "joomla"); // database username 
define("DB_PASSWORD", "joomla"); // database password
define("ADMIN_PASSWORD", "admin"); // database password
//Error handling
define("DEBUG_TYPE", "browser"); // the errors can be shown on the browser or sent by email, values : (browser, email, be) be - will send by email and display on browser
define("EM_SEND_DB_ERR", ""); // email where to send database errors
// General Site Configuration
