<?php
/**
 * @version    $Id: $
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

 
include("inc.all.php");
if (get_setting("otobckeactive")==1)
{
	$t->set_var("email", $_COOKIE["emailx"]);
	$t->set_file("content", "login.oto.html");
}
else
{
	header("location:login.php");
}
include("inc.bottom.php");
?>