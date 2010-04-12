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
	$querystring = '';
	
	$query="select * from autoresponder_config where arp_id='".get_setting("arp_in_use")."' order by id";
	$q->query($query);
	while($q->next_record()){
		if ($q->f('field') == 'email') $email = $q->f('value');
	}
	
	$q->query("SELECT email FROM members");
	while($q->next_record()){
		if ($q->f('email') == $$email){
			$querystring = 'double_email=1';
			break;
		}else{
			$querystring = 'double_email=0';
		}
	}
	
	foreach ($HTTP_GET_VARS as $name => $value){
		$querystring .= "&$name=$value";
	}
	
	header("Location: signup.php?$querystring");
	?>