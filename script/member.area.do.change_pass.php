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
    $q2 = new Cdb;
    get_logged_info(); //member area init...
    $member_id = $q->f("id");
  
    if (($new_pass == $re_pass) && $new_pass != "") {
        $q2->query("UPDATE members SET password=MD5('$new_pass') WHERE id='$member_id'");
        $err = 3;
    } else {
        $err = 2;
    }
 
    header("Location: member.area.change_pass.php?err=$err");
    exit;
?>
