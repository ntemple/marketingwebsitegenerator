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

 
	include "inc.all.php";
	if ($password==ADMIN_PASSWORD)
	{
		$admin_sess_id=md5(get_setting("secret_string")."-".ADMIN_PASSWORD);
		$_SESSION["admin_sess_id"] = $admin_sess_id;
		header("location:index.php?menu=settings");
	}
	else
	header("location:login.php");
?>
