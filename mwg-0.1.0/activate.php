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
if ($code=='') die('Please click the link you received in your email');
$query="SELECT email, password FROM members WHERE code='$code'";
$q->query($query);
$q->next_record();
$email=$q->f('email');
$password=$q->f('password');
$query="update members set active=1 where code='$code'";
$q->query($query);
$query="select * from members where email='$email' and password='$password'";
$q->query($query);
if ($q->nf()==0)
{
	$t->set_file("content", "do.login.error.html");
	include("inc.bottom.php");
}
else
{
	$q->next_record();
	
	$sess_id=md5(get_setting("secret_string").$q->f("id"));
		
	$_SESSION["sess_id"] = $sess_id;
	
	setcookie("emailx",$q->f("email"),time()+99999);
	
	
	header("Location: member.area.in.php");
	die();
}
header("location:member.area.in.php");
die();
?>