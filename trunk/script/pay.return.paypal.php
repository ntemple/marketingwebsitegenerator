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
  
  $t->set_file("content","payment.ty.html");
  
  $session = str_replace('/', '', $GLOBALS['PATH_INFO']);
  $t->set_var("siteowner", get_setting("webmaster_contact_email"));
  $t->set_var("sitename",SITENAME);
  
  $query="select * from session where session_id='$session'";
  $q->query($query);
  if ($q->nf()!=0)
  {
  	 $q->next_record();
	 if ($q->f("paid")==1) 
	 {
	 	header("Location: continue.php");
		die();
	 }
  }
  
include("inc.bottom.php");
?>