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
		
	$q2 = new CDb();
	
	set_setting("enable_arp",$enable_arp);	
	set_setting("arp_in_use_type", $arp);
	
	if ($edit){
		
		$query="UPDATE autoresponder_config SET value='".$_POST["method"]."' WHERE field='method' AND arp_id='".$_GET['arp_id']."'";
		$q->query($query);
		$query="UPDATE autoresponder_config SET value='".$_POST["arp_name"]."' WHERE field='arp_name' AND arp_id='".$_GET['arp_id']."'";
		$q->query($query);
		$query="UPDATE autoresponder_config SET value='".(substr($_POST["url"],0,7) == "http://" ? $_POST["url"] : "http://".$_POST["url"])."' WHERE field='url' AND arp_id='".$_GET['arp_id']."'";
		$q->query($query);
		$query="UPDATE autoresponder_config SET value='".$_POST["first_name"]."' WHERE field='first_name' AND arp_id='".$_GET['arp_id']."'";
		$q->query($query);
		$query="UPDATE autoresponder_config SET value='".$_POST["email"]."' WHERE field='email' AND arp_id='".$_GET['arp_id']."'";
		$q->query($query);
		
		$q->query("SELECT * FROM autoresponder_config WHERE field!='method' AND field!='url' AND field!='first_name' AND field!='email' AND field!='arp_name' AND arp_id='".$_GET['arp_id']."' order by id");
		$i=1;
		while ($q->next_record()) {
			$query="UPDATE autoresponder_config SET field='".$_POST["field".$i]."' WHERE id='".$q->f('id')."'";
			$q2->query($query);
			$query="UPDATE autoresponder_config SET value='".$_POST["value".$i]."' WHERE id='".$q->f('id')."'";
			$q2->query($query);
			$i++;
		}
		
		set_setting("arp_in_use", $_GET['arp_id']);
	}
	if ($new){
		$query="select MAX(arp_id) as a from autoresponder_config";
		$q->query($query);
		$q->next_record();
		$nextid=$q->f("a")+1;
		
		$query="insert into autoresponder_config (field, value, arp_id) values ('first_name', '$first_name', '$nextid')";
		$q->query($query);
		$query="insert into autoresponder_config (field, value, arp_id) values ('method', '$method', '$nextid')";
		$q->query($query);
		$query="insert into autoresponder_config (field, value, arp_id) values ('arp_name', '$arp_name', '$nextid')";
		$q->query($query);
		$query="insert into autoresponder_config (field, value, arp_id) values ('url', '$url', '$nextid')";
		$q->query($query);
		$query="insert into autoresponder_config (field, value, arp_id) values ('email', '$email', '$nextid')";
		$q->query($query);
		
		for ($i=1; $i<=10;$i++){
			$query="insert into autoresponder_config (field, value, arp_id) values ('".$_POST["field".$i]."', '".$_POST["value".$i]."', '$nextid')";
			$q->query($query);
		}
		set_setting("arp_in_use", $nexid);
	}
if(!$edit && !$new){
	set_setting("arp_email",$arp_email);
	set_setting("arp_message_subject", $arp_message_subject);
	set_setting("arp_message_body", $arp_message_body);
}
	header("Location: signup.settings.php?arp_id=".$arp_id);
		
?>