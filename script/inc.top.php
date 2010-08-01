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

// @todo: refactor. These are basic checks that need to go into the routing file

if (mwgSession::isLoggedIn()) {

  // Make sure activation email has been sent
  if (get_setting("activation_email")==1 )
  {

    $query="select active from members where mdid='$sess_id'";
    $q->query($query);
    $q->next_record();
    if ($q->f("active")!=1){ header("location:activation.php"); exit;}

  }
  
  // Make sure we aren't suspended and we have a password
  $query="select suspended, password from members where mdid='$sess_id'";
  $q->query($query);
  $q->next_record();
  if ($q->f("suspended")==1) {
    header("location:accountsuspended.php");
    die();
  } elseif ($q->f("password")==md5("")) {
    header("location:member.area.in.php?pss=1");
    die();
  }

}