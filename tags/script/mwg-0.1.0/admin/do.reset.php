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
$q2=new cdb;
$redirect=urldecode($_GET[page]);
$memberstoreset=explode("|", $membersreset);
foreach ($memberstoreset as $member)
{
	if ($member!="")
	{
		$query="update members set password='".md5($reset)."' where id='$member'";
		
		$q->query($query);
		$query="select * from members where id = '$member'";
		
		$q->query($query);
		$q->next_record();
		$emailto=$q->f("email");
		
		$email_bodyx=str_replace("{password}", $reset, $email_body);
		$email_subjectx=str_replace("{password}", $reset, $email_subject);
		$email_bodyx=str_replace("[sitename]", get_setting("site_name"), $email_bodyx);
		
		$query="select * from tags";
		$q2->query($query);
		while ($q2->next_record())
		{
			$email_subjectx=str_replace("{".$q2->f("title")."}", $q->f($q2->f("field")), $email_subjectx);
			$email_bodyx=str_replace("{".$q2->f("title")."}", $q->f($q2->f("field")), $email_bodyx);
			
		}
	
		mail($emailto, $email_subjectx, $email_bodyx, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
	}
}
header("location:members.php?page=$redirect");
?>