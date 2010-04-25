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
	$query="select * from members where id='$id'";
	$q->query($query);
	$q->next_record();
	$member_id=$id;
	$redirect=urldecode($_GET[page]);
	if ($q->f("email")!=$email)
	{
		$query="select count(*) as n from members where email='$email'";
		$q->query($query);
		$q->next_record();
		
		if ($q->f("n")!=0) 
		{
			// got duplicate email here.... not saving ...
			
			echo 'Duplicate email <a href="javascript:history.go(-1)">Back</a>';
			
			
		}
	}
	
	// if we got here mean all ok , so we need to save
		$query="update members set 
		
		email='$email',
		password=MD5('$password'), 
		city='$city', 
		first_name='$first_name', 
		last_name='$last_name', 
		state='$state', 
		address='$address', 
		country='$country', 
		zip='$zip', 
		home_phone='$home_phone', 
		work_phone='$work_phone', 
		cell_phone='$cell_phone', 
		country='$country', 
		ssn='$ssn' ,
		public_profile='$public_profile' , 
		paypal_email='$paypal_email', 
		msn_id='$msn_id' ,
		yahoo_id='$yahoo_id' ,
		p_home_phone='$p_home_phone' ,
		p_work_phone='$p_work_phone' ,
		p_cell_phone='$p_cell_phone' ,
		p_address='$p_address' ,
		p_first_name='$p_first_name' ,
		p_last_name='$p_last_name' ,
		p_paypal_email='$p_paypal_email' ,
		p_msn_id='$p_msn_id' ,
		p_yahoo_id='$p_yahoo_id' ,
		p_icq_id='$p_icq_id' ,
		p_url1='$p_url1' ,
		p_url2='$p_url2' ,
		p_url3='$p_url3' ,
		p_state='$p_state', 
		p_address='$p_address', 
		p_country='$p_country', 
		p_zip='$p_zip', 
		p_city='$p_city' ,
		icq_id='$icq_id' ,
		url1='$url1' ,
		url2='$url2' ,
		url3='$url3' ,
		membership_id='$membership_id'
		where id='$member_id'";
		$q->query($query);	
		
		header("Location: members.php?page=$redirect");
		
?>
