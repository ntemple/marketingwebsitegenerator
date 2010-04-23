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


include ("inc.all.php");
$t->set_file("content", "activation.html");
if (get_setting("activation_email")==1)
{
  get_logged_info();
  $member_id = $q->f("id");
  $email=$q->f("email");
  $emailsubject=get_setting("activation_email_subject");
  $emailsubject=str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$q->f("code"), $emailsubject);
  $emailbody=get_setting("activation_email_body");
  $emailbody=str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$q->f("code"), $emailbody);
  mwg_mail($email, email_replace2($emailsubject,$member_id), email_replace2($emailbody), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
}
include ("inc.bottom.php");
