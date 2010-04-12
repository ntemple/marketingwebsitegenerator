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

 
include("inc.top.php");
$q2=new CDB;
	$t->set_file("content", "member.area.earn.money.ag.html");
	 get_logged_info();
	 $query="SELECT id FROM menus WHERE link='member.area.earn.money.ag.php'";
	 $q2->query($query);
	 $q2->next_record();
	 $query="SELECT membership_id FROM menu_permissions WHERE menu_item='".$q2->f("id")."'";
	 $q2->query($query);
	 while ($q2->next_record()) {
	 	$permissions[]=$q2->f("membership_id");
	 }
	 if (count($permissions)>0) {
	 	$error='<center><font color="red"><b>You do not have access to this area!<br><br>Upgrade your membership level!</b></font></center>';
	 	foreach ($permissions as $value) {
	 		if ($value==$q->f("membership_id")) {
	 			$error='';
	 			break;
	 		}
		}
		if ($error!="") {
			die("$error");
		}
	 }
	 replace_tags_t($q->f("id"), $t);
	
include("inc.bottom.php");
?>