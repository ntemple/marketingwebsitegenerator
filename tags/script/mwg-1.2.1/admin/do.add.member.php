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
	
	if ($email=="")  $error.="You must enter your email address.<br>";
	$query="select * from members where email='$email'";
	$q->query($query);
	if ($q->nf()!=0) $error.="The email address you filled in is already in our database.<br>";
	
	if ($first_name=="")  $error.="You must enter your firstname.<br>";
	if ($password=="")  $error.="You must enter your password.<br>";
	
	if ($error!="")
	{
		$t->set_file("content", "signup.error.html");
		foreach ($_POST as $key => $value) 
		{
		  $value = urlencode(stripslashes($value));
		  $req .= "&$key=$value";
		}
		
		$t->set_var("req", $req);
		$t->set_var("errors", $error);
		
	}
	else
	{
		// insert new member in database
		$query="insert into members  (
					id,
					email,
					password,
					paypal_email,
					first_name,
					last_name,
					city,
					state,
					zip,
					country,
					address,
					home_phone,
					work_phone,
					cell_phone,
					icq_id,
					msn_id,
					yahoo_id,
					ssn,
					aff,
					s_date,
					membership_id
					)values(
					NULL,
					'$email',
					'".md5($password)."',
					'$paypal_email',
					'$first_name',
					'$last_name',
					'$city',
					'$state',
					'$zip',
					'$country',
					'$address',
					'$home_phone',
					'$work_phone',
					'$cell_phone',
					'$icq_id',
					'$msn_id',
					'$yahoo_id',
					'$ssn',
					'".$_COOKIE["aff"]."',
					'".time()."',
					'$membership_id')";
					
		$q->query($query);
		$member_id = mysql_insert_id($q->link_id());
		$query="update members set mdid='".md5(get_setting("secret_string").$member_id)."' where id='$member_id'";
		mysql_query($query);
		header ("location:members.php");
}
include("inc.bottom.php");
?>
