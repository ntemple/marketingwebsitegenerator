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
$query="select * from members where email='$email'";
$q->query($query);
if ($q->nf()==0)
{
	$t->set_file("content", "do.forgot.error.html");
	include("inc.bottom.php");
}
else
{
	$new_pass=GetRandomString(10);
	$new_pass_md5=md5($new_pass);
	
	if (strpos($email, ":")!== false) echo "Your email contains invalid characters.<br>";
	else
	if (strpos($email, "/")!== false) echo "Your email contains invalid characters.<br>";
	else
	if (strpos($email, "\\")!== false) echo "Your email contains invalid characters.<br>";
	else
	if (strpos($email, ";")!== false) echo "Your email contains invalid characters.<br>";
	else
	if (strpos($email, "=")!== false) 
	$error.="Your email contains invalid characters<br>";
	else
	{
		$query="update members set password='$new_pass_md5' where email='$email'";
		$q->query($query);
		
		$query="select * from members where email='$email'";
		$q->query($query);
		$q->next_record();
		
		$first_name=$q->f("first_name");
		$last_name=$q->f("last_name");
		$password=$new_pass;
		
		@mail($email, email_replace(get_setting("lostpass_email_subject"), $email, $first_name, $last_name, $password), email_replace(get_setting("lostpass_email_body"), $email, $first_name, $last_name, $password), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
		$t->set_file("content", "do.forgot.password.html");
		include("inc.bottom.php");
	}
	
}
?>