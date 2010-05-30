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
$q2=new CDB;
get_logged_info(); //member area init...
	$t->set_file("content", "member.area.change_pass.html");
	if ($err == 1) $t->set_var("error","Please retype the old password");
	elseif ($err == 2) $t->set_var("error","The two passwords do not match");
    elseif ($err == 3) $t->set_var("error", "Thank You. Your Password Has Been Changed.");
	else $t->set_var("error","");
include("inc.bottom.php");
?>
