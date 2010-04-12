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

 
	include("inc.top.php");
	$query="update settings set value='$signup_with_code' where name='signup_with_code'";
	$q->query($query);
	$query="update settings set value='$signup_code' where name='signup_code'";
	$q->query($query);
	$query="update settings set value='$credits_enable' where name='enable_credit'";
	$q->query($query);
	$query="update settings set value='$credits' where name='nr_credit'";
	$q->query($query);
	set_setting("text_for_signup_code", $text_for_signup_code);
	header("location:signup.settings.php");
	
?>