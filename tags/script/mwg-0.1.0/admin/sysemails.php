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
	$t->set_file("content", "admin.sysemails.html");
	$t->set_file("setting", "admin.settings.row.html");
	$t->set_file("settingcategory", "admin.sysemails.row.html");
	$query="select * from settings where name like '%_email%' and box_type!='hidden' and id!=13 and id!=9 order by cat, rank";
	$q->query($query);
	$category='';
	while ($q->next_record())
	{
		$t->set_var("sett",$q->f("id"));
		if ($category!=$q->f("cat"))
		{
			$category=$q->f("cat");
			$t->set_var("setting_category", "<h3>".$category."</h3>");
			$t->parse("settings_list", "settingcategory", true);
		}
		if ($q->f("box_type")=="textbox")
		{
			
			$set='<textarea name="'.$q->f("name").'" id="'.$q->f("name").'" cols="50" rows="6">'.stripslashes($q->f("value")).'</textarea>';
			$desc=$q->f("description");
			if ($q->f('name') == 'activation_email_body'){
				if (!$activation_email_type_chck && !$activation_email_chck){
					$t->set_var("disp_".$q->f('id'),'none');
				}elseif ($activation_email_type_chck !=2)
					$t->set_var("disp_".$q->f('id'),'none');
				$id_activation_email_body = $q->f('id');
			}
		}
		if ($q->f("box_type")=="input")
		{
			if ($q->f('name') == 'activation_code_email'){
				if (!$activation_email_chck){
					$t->set_var("disp_".$q->f('id'),'none');
				}elseif ($activation_email_type_chck !=2)
					$t->set_var("disp_".$q->f('id'),'none');
				$id_activation_code_email = $q->f('id');
			}
			if ($q->f('name') == 'activation_email_subject'){
				if (!$activation_email_type_chck && !$activation_email_chck){
					$t->set_var("disp_".$q->f('id'),'none');
				}elseif ($activation_email_type_chck !=2)
					$t->set_var("disp_".$q->f('id'),'none');
				$id_activation_email_subject = $q->f('id');
			}
			$set='<input type="text" name="'.$q->f("name").'" id="'.$q->f("name").'" value="'.stripslashes($q->f("value")).'" size="40">';
			$desc=$q->f("description");
		}
		if ($q->f("box_type")=="checkbox")
		{
			if ($q->f("value")==1)
			$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked>';
			else $set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1">';
			$desc=$q->f("description");
			
			if ($q->f('name') == 'activation_email'){
				if ($q->f("value")==1){
					$activation_email_chck = 1;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" checked onclick="{activation_email_fct()}">';
				}else{
					$activation_email_chck = 0;
					$set='<input type="checkbox" name="'.$q->f("name").'" id="'.$q->f("name").'" value="1" onclick="{activation_email_fct()}">';
				}
				$desc=$q->f("description").'<a name="activation">';
			}
		}
		if ($q->f("box_type")=="hidden")
		{
			$set='<input type="hidden" name="'.$q->f("name").'" id="'.$q->f("name").'" value="'.$q->f("value").'">';
			$desc='';
		}
		if ($q->f("box_type")=="select" && $q->f("name") == "change_membership"){
			$set = '<select name="'.$q->f("name").'" id="'.$q->f("name").'" >
			 <option>Chose membership</option>';
			$q2->query("SELECT name, id FROM membership WHERE active=1");
			while($q2->next_record()){
				if ($q2->f("id") == $q->f("value")) $selected = "selected";
				else $selected = "";
				$set .= '<option value="'.$q2->f("id").'" '.$selected.'>'.$q2->f("name").'</option>';
			}
			$set .= '</select>';
			$desc=$q->f("description");
		}
		
		if ($q->f("box_type")=="select" && $q->f("name") == "default_free"){
			$set = '<select name="'.$q->f("name").'" id="'.$q->f("name").'" >
			 <option>Chose membership</option>';
			$q2->query("SELECT name, id FROM membership WHERE active=1");
			while($q2->next_record()){
				if ($q2->f("id") == $q->f("value")) $selected = "selected";
				else $selected = "";
				$set .= '<option value="'.$q2->f("id").'" '.$selected.'>'.$q2->f("name").'</option>';
			}
			$set .= '</select>';
			$desc=$q->f("description");
		}
		$t->set_var("setting_box", $set);
		if ($q->f("name") == "enable_jv"){
			$desc = str_replace("{url}",get_setting("site_full_url"),$q->f("description"));
		}
		
		if ($q->f("box_type")=="select" && $q->f("name") == "jv_membership"){
			$set = '<select name="'.$q->f("name").'" id="'.$q->f("name").'" >
			 <option>Chose membership</option>';
			$q2->query("SELECT name, id FROM membership WHERE active=1");
			while($q2->next_record()){
				if ($q2->f("id") == $q->f("value")) $selected = "selected";
				else $selected = "";
				$set .= '<option value="'.$q2->f("id").'" '.$selected.'>'.$q2->f("name").'</option>';
			}
			$set .= '</select>';
			$desc=$q->f("description");
		}
		if ($q->f("box_type")=="radio")
			if ($q->f('name') == 'activation_email_type'){
				$id_activation_email_type = $q->f('id');
				if ($q->f("value")==1){
					$activation_email_type_chck = 0;
					$set = '<input type="radio" name="activation_email_type" id="activation_email_type" value="1" checked onclick="{activation_email_type_fct()}">Have The System automatically send an activation link to the member to click after they join.<br><br><input type="radio" name="activation_email_type" id="activation_email_type" value="2" onclick="{activation_email_type_fct()}">I will use my own 3rd party auto responder to send an email to the customer with this activation code.';
				}elseif ($q->f("value")==2){
					$activation_email_type_chck = 1;
					$set = '<input type="radio" name="activation_email_type" id="activation_email_type" value="1" onclick="{activation_email_type_fct()}">Have The System automatically send an activation link to the member to click after they join.<br><br><input type="radio" name="activation_email_type" id="activation_email_type" value="2" checked onclick="{activation_email_type_fct()}">I will use my own 3rd party auto responder to send an email to the customer with this activation code.';
				}
				
				$desc=$q->f("description");
			}
		$t->set_var("setting_box", $set);
		$t->set_var("setting_description", stripslashes(stripslashes($desc)));
		$t->parse("settings_list", "setting", true);
	}
			$chck_funtions = "activation_email_type_fct('$id_activation_code_email','$id_activation_email_subject','$id_activation_email_body');activation_email_fct('$id_activation_email_type','$id_activation_code_email','$id_activation_email_subject','$id_activation_email_body');";
			$t->set_var('activation_email_fct()',"activation_email_fct('$id_activation_email_type','$id_activation_code_email','$id_activation_email_subject','$id_activation_email_body');");
			$t->set_var('activation_email_type_fct()',"activation_email_type_fct('$id_activation_code_email','$id_activation_email_subject','$id_activation_email_body')");
			$t->set_var("chck_funtions", $chck_funtions);
include("inc.bottom.php");
?>