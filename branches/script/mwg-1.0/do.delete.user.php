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

 
include("inc.all.php");
	
$q=new Cdb;
if (get_setting("delete_acount") == 1){
	$q->query("DELETE from members where MD5(CONCAT('".get_setting("secret_string")."',ID))='$sess_id'");
}
header("Location: index.php");
session_destroy();
exit;
?>