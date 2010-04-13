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

 
require_once("inc.all.php");
if (!$admin_sess_id)
{
	header("location:login.php");
	die();
}
if (isset($admin_sess_id))
{
	if ($admin_sess_id!=md5(get_setting("secret_string")."-".ADMIN_PASSWORD))
	{
		session_destroy();
		header("location:login.php");
		die();
	}
}
genstall_admin_start();

