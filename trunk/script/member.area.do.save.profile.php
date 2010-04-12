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
$q2=new Cdb;
$q3=new CDB;
	get_logged_info(); //member area init...
	$member_id=$q->f("id");
	
	//cecking for duplicate email address
	
	if ($q->f("email")!=$email)
	{
		$query="select count(*) as n from members where email='$email'";
		$q->query($query);
		$q->next_record();
		
		if ($q->f("n")!=0) 
		{
			
			$t->set_file("content","member.area.do.save.profile.error.html"); 
			
			include("inc.bottom.php");
			die();
		}
	}
	
	$updatequery="update members set ";
	$query="select * from signup_settings where membersarea=1";
	$q->query($query);
	$i=0;
	while ($q->next_record())
	{
		$gasit_var = 0;
		
		
		if ($q->f("field")!="password"){
	
			if ($q->f("field") == "email"){
				preg_match("/^[A-Za-z0-9][\w-.]*[A-Za-z0-9]*@[A-Za-z0-9]*([\w-.]*[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i",$_POST['email'],$match);
				if(!@$match[0]){
					header("Location: member.area.profile.php?err=email");
					exit;
				}
			}
			if ($q->f("required")){
				if ($_POST[$q->f("field")] == ""){
					header("Location: member.area.profile.php?err=required_fields");
					exit;
				}
			}
				
			$updatequery.=$q->f("field")."='".$_POST[$q->f("field")]."',";
				
			
		}
			if (get_setting("enable_profile_directory")==1 && $q->f("field")!="password")
	
				{
					$gasit = "";
					$q3->query("SHOW COLUMNS FROM members");
					while ($q3->next_record()){
						preg_match("'^p_.*'",$q3->f("Field"),$match);
						$match[0] ? $gasit .= $match[0]."," : $gasit.= "";
					}
					$pattern = "'".$q->f("field").",'";
					preg_match($pattern,$gasit,$match);
				
					if ($match[0]){  $gasit_var = 1; }
					
					
					if (empty($_POST["p_".$q->f("field")]) && $gasit_var)
					$updatequery.="p_".$q->f("field")."='0',";
					elseif ($gasit_var) $updatequery.="p_".$q->f("field")."='1',";
				}
				
	}
		
		$updatequery = substr($updatequery,0,-1);
		$updatequery.=", public_profile='$public_profile'";
		$updatequery.=" where id='$member_id'";
		$q->query($updatequery);	
		
		
		header("Location: member.area.profile.php");
		
?>