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

 
include ("inc.top.php");
if ($sendto==1)
{
	$query="select email from members where id='$id'";
	$q->query($query);
	$q->next_record();
	mail($q->f("email"), $subject, $body, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
	$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('$id', '1', '".addslashes($subject)."', '".addslashes($body)."', NOW(), NOW())";
	$q->query($query);
	echo '<div align=center>Message & Email sent <br><a href="javascript:window.self.close()">Close window</a></div>';
	
}
if ($sendto==2)
{
	$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('$id', '1', '".addslashes($subject)."', '".addslashes($body)."', NOW(), NOW())";
	$q->query($query);
	echo '<div align=center>Message sent <br><a href="javascript:window.self.close()">Close window</a></div>';
}
if ($sendto==3)
{
	$query="select email from members where id='$id'";
	$q->query($query);
	$q->next_record();
	mail($q->f("email"), $subject, $body, "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
	echo '<div align=center>Email sent <br><a href="javascript:window.self.close()">Close Window</a></div>';
}
	
?>