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
if (get_setting("cut_signup")==1)
{
	$t->set_file("content", "create.pass.html");
	get_logged_info();
	$member_id=$q->f("id");
	if ($go)
		
		if ($pass!=$cpass) 
		{
			
			$t->set_var("error","The Password and Password Confirmation did not match. Please try again");
			
		}
		else
		{
			$query="update members set password=md5('$pass') where id='$member_id'";
			$q->query($query);
			if (get_setting('send_welcome_emails')==1 )
				{
				$q->query("SELECT * FROM members WHERE id='$member_id'");
				mwg_mail($q->f("email"), email_replace(get_setting("welcome_email_subject"), $q->f("email"), $q->f("first_name"), $q->f("last_name"), $pass), email_replace(get_setting("welcome_email_body"), $q->f("email"), $q->f("first_name"), $q->f("last_name"), $pass), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
				}
			header("location:member.area.in.php");
			die();
		}	
	include("inc.bottom.php");
}
else {
	header("location:continue.php");
}
?>