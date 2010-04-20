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

 
function get_setting($setting_name)
{
	$q=new Cdb;
	$query="select value from settings where name='$setting_name'";
	$q->query($query);
	if ($q->nf()==0) return -1; // cannot find the setting in table
	
	$q->next_record();
	
	return stripslashes($q->f("value")); // return setting value
}
function get_signup_setting($setting_name)
{
	$q=new Cdb;
	$query="select value from signup_settings where name='$setting_name'";
	$q->query($query);
	if ($q->nf()==0) return -1; // cannot find the setting in table
	
	$q->next_record();
	
	return stripslashes($q->f("value")); // return setting value
}
function set_setting($setting_name, $setting_value)
{
	$q=new Cdb;
	$setting_value=addslashes(stripslashes($setting_value));
	$query="update settings set value='$setting_value' where name='$setting_name'";
	$q->query($query);
}
// end of functions for setting table
//functions for main menu and members area menu
function generate_main_menu()
{
	$q=new Cdb;
	
	$query="select * from menus where menu_category='main' and active='1' order by position asc, id asc";
	$q->query($query);
	
	
	if ($q->nf()!=0)
	{
		$q->next_record();
		$main_menu="<a href='".$q->f("link")."'>".$q->f("name")."</a>";
	}
	else
		return;
	
	if (get_setting("verticalmenumain")==1)
	$separator="<Br><br>";
	else
	$separator=" | ";
	while ($q->next_record())
	{
		if ($q->f("open_new_window")==1)
		{
			$new_win=" target='_blank' ";
		}
		else
		{
			$new_win="  ";
		}
		$main_menu.=" $separator <a href='".$q->f("link")."' $new_win >".$q->f("name")."</a>";
	}
	return $main_menu;
}
function generate_members_menu($membership_id)
{
	$q=new Cdb;
	$q2=new Cdb;
	$query="select * from menus where menu_category='members' and active='1' order by position asc, id asc";
	$q->query($query);
	if ($q->nf()!=0)
	{
		$q->next_record();
		$main_menu="<a href='".$q->f("link")."'>".$q->f("name")."</a>";
	}
	else
		return;
	
	if (get_setting("verticalmenumembers")==1)
	$separator="<Br><br>";
	else
	$separator=" | ";
	while ($q->next_record())
	{
		if ($q->f("open_new_window")==1)
		{
			$new_win=" target='_blank' ";
		}
		else
		{
			$new_win="  ";
		}
		$query="select * from menu_permissions where menu_item='".$q->f("id")."'";
		$q2->query($query);
		if ($q2->nf()==0)
			$main_menu.=" $separator <a href='".$q->f("link")."' $new_win>".$q->f("name")."</a>";
		else 
		{
			$query="select * from menu_permissions where menu_item='".$q->f("id")."' and membership_id='$membership_id'";
			$q2->query($query);
			if ($q2->nf()!=0) $main_menu.=" $separator <a href='".$q->f("link")."' $new_win>".$q->f("name")."</a>";
		}
	}
	
	return $main_menu;
}
//end of functions for main menu and members area menu
//error functions
function error_halt($error_str, $t)
{
	$t->set_file("content", "error.html");
	$t->set_var("sitename", SITENAME);
	$t->set_var("details", $error_str);
	
			if (DEBUG_TYPE=="browser" || DEBUG_TYPE=="be")
			{
				$t->pparse("out", "content");
			}
			else
			if (DEBUG_TYPE=="email" || DEBUG_TYPE=="be")
			{
				mwg_mail(EM_SEND_DB_ERR, SITENAME." Mysql Error",  $error_str, "From: ".SITENAME."<noreply@noreply.com>");
			}
	die("<br>Script execution halted.");
}
//end of error functions
//functions for generating random strings/ session
function GetRandomString($length) {
		settype($template, "string");
		$template = "1234567890abcdefghijklmnopqrstuvwxyz";
       settype($length, "integer");
       settype($rndstring, "string");
       settype($a, "integer");
       settype($b, "integer");
      
       for ($a = 0; $a <= $length; $a++) {
               $b = rand(0, strlen($template) - 1);
               $rndstring .= $template[$b];
       }
      
       return $rndstring;
      
}
function new_sess_id()
{
	return GetRandomString(64);
}
//end of functions for generating random strings /sessions
// functions to replace [firstname], ... in strings
function email_replace($str, $email, $firstname, $lastname, $password)
{
	$str=str_replace("[firstname]", $firstname, $str);
	$str=str_replace("[lastname]", $lastname, $str);
	$str=str_replace("[password]", $password, $str);
	$str=str_replace("[email]", $email, $str);
	$str=str_replace("[sitename]", SITENAME, $str);
	
	return $str;
}
// end of functions to replace [firstname], ... in strings
function email_replace2($str, $member_id)
{
	$q=new Cdb;
	$q2=new Cdb;
	$query="select * from members where id='$member_id'";
	$q->query($query);
	$q->next_record();
	$query="select * from tags";
	$q2->query($query);
	while ($q2->next_record())
	{
		$str=str_replace("{".$q2->f("title")."}", $q->f($q2->f("field")), $str);
	}
	
	return $str;
}
// functions for member area
function get_logged_info()
{
	global $t,$q, $sess_id;
	
	if (!isset($sess_id)) 
	{
		// there is no member logged so we die here...
		$t->set_file("content","member.area.error.html");
		include("inc.bottom.php");
		
		die();
	}
	$query="select * from members where '$sess_id'=MD5(CONCAT('".get_setting("secret_string")."',id))";
	$q->query($query);
	if ($q->nf()==0)
	{
		//ooops... we did not find the registered user, hack attempt ? 
		session_destroy(); // we destroy the bad session here...
		
		$t->set_file("content","member.area.error.html"); // and we display session expired page... 
		include("inc.bottom.php");
		
		die();
	}
	
	// ok last we pos at the registered member
	$q->next_record();
	
	
}
//end of functions for member area
// function to determine how many unread messages are in the inbox
function get_unread_inbox()
{
	global $sess_id;
	$q=new Cdb;
	$query="select count(*) as n from messages where '$sess_id'=MD5(CONCAT('".get_setting("secret_string")."',member_id)) and read_flag=0";
	$q->query($query);
	if ($q->nf()==0)
	{
		//ooops... we did not find the registered user, hack attempt ? 
		session_destroy(); // we destroy the bad session here...
		
		$t->set_file("content","member.area.error.html"); // and we display session expired page... 
		include("inc.bottom.php");
		
		die();
	}
	
	// ok last we pos at the registered member
	$q->next_record();
	return $q->f("n");
}
//end of  function to determine how many unread messages are in the inbox
// function to generate affiliate id
function get_aff_link($member_id) 
{
	$aff_link=get_setting("site_full_url")."?".get_setting("affiliate_variable")."=".$member_id;
	return $aff_link;
}
//end of function to generate affiliate id
	function encodeHTML($sHTML)
		{
		$sHTML=ereg_replace("&","&amp;",$sHTML);
		$sHTML=ereg_replace("<","&lt;",$sHTML);
		$sHTML=ereg_replace(">","&gt;",$sHTML);
		return $sHTML;
		}
	function FFileRead($name/*filename*/, &$contents/*returned contents of file*/)
	{
		$fd = fopen ($name, "r");
		$contents = fread ($fd, filesize ($name));
		fclose ($fd);
	}
	function FFileWrite($name, $content, $w="w+")
	{
		$filename = $name;
		$somecontent = $content;
		
		// Let's make sure the file exists and is writable first.
		if (is_writable($filename)) {
		
		   // In our example we're opening $filename in append mode.
		   // The file pointer is at the bottom of the file hence
		   // that's where $somecontent will go when we fwrite() it.
		   if (!$handle = fopen($filename, $w)) {
				 echo "Cannot open file ($filename)";
				 exit;
		   }
		
		   // Write $somecontent to our opened file.
		   if (fwrite($handle, $somecontent) === FALSE) {
			   echo "Cannot write to file ($filename) please make sure that you chmod 777 templates folder";
			   exit;
		   }
		  
		  
		   fclose($handle);
		
		} else {
		   echo "The file $filename is not writable please make sure that you chmod 777 templates folder";
		}
	}
	function FFileWriteNew($name, $content, $w="w+")
	{
		$filename = $name;
		$somecontent = $content;
		
		// Let's make sure the file exists and is writable first.
		   if (!$handle = fopen($filename, $w)) {
				 echo "Cannot open file ($filename)";
				 exit;
		   }
		
		   // Write $somecontent to our opened file.
		   if (fwrite($handle, $somecontent) === FALSE) {
			   echo "Cannot write to file ($filename) please make sure that you chmod 777 templates folder";
			   exit;
		   }
		  
		  
		   fclose($handle);
		
	}
// function to replace tags in $t
function replace_tags_t($user_id, &$t)
{
	$q=new Cdb;
	$query="select * from tags";
	$q->query($query);
	$q2=new Cdb;
	$query="select * from members where id='$user_id'";
	$q2->query($query);
	if ($q2->nf()==0) return false;// no user found
	$q2->next_record();
	while ($q->next_record())
	{
		
		$t->set_var($q->f("title"), $q2->f($q->f("field")));
	}
	$b=get_aff_link($user_id);
	$t->set_var("aff_link", $b);
	return true;
}
//end of function to replace tags in $t
//Function replace tags in messages
function ReplaceTags($stringtoreplace, $member_id, &$replacedstring)
{
	$q=new CDB;
	$q2=new CDB;
	
	$query="select * from members where id='$member_id'";
	$q->query($query);
	$q->next_record();
	$query="select * from tags";
	$q2->query($query);
	$replacedstring=$stringtoreplace;
	while ($q2->next_record())
	{
		$replacedstring=str_replace("[[".$q2->f("title")."]]", $q->f($q2->f("field")), $replacedstring);
	}
	$b=get_aff_link($member_id);
	$replacedstring=str_replace("[[aff_link]]", $b, $replacedstring);
}
// end of function
//Function that returns tag list in a string
function GetTags(&$tags,  $separator="{}")
{
	$q=new CDB;
	$query="select title from tags";
	$q->query($query);
	$i=1;
	if ($separator=="{}") $tags="{aff_link} ";
	if ($separator=="[[]]") $tags="[[aff_link]] ";
	while ($q->next_record())
	{
		if ($i==1) 
		{
			if ($separator=="{}") $tags.="{".$q->f("title")."}";
			else $tags="[[".$q->f("title")."]]";
			$i=2;
		}
		else if ($separator=="{}") $tags.=" {".$q->f("title")."}";
			else $tags=" [[".$q->f("title")."]]";
	}
	
}
//end of function
function execute_sql($filename)
{
	$q=new Cdb;
	FFileRead($filename, $content);
	
	$a=explode(";", $content);
	$k=0;
	
	while ($a[$k]!="")
	{
		$query=$a[$k];
		$q->query($query);
		$k++;
	}
}
function GetPayButtonsList(&$t)
{
	$t->set_file("productlist", "admin.membership.insert.pay.buttons.html");
	$q=new CDb;
	$query="select * from products";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("product_unique", $q->f("nid"));
		$t->set_var("product_name", $q->f("display_name"));
		$t->set_var("product_price", $q->f("price"));
		$t->parse("product_list", "productlist", true);
	}
	if ($q->nf()==0) $t->set_var("product_list", "");
	return true;
}
//function to get db fields in different formats
function getdbfields($returntype="", $itemsperrow)
	{
		$q=new Cdb;
		$a=$q->metadata("members", false);
		$j=0;
		$k=0;
		foreach ($a as $b)
		{
				
				$i=0;
				foreach ($b as $c)
				{
					if ($i==1) 
					{
						if ($returntype=="check")
						{
							if ($k%$itemsperrow==0) 
							{
								$return.="<tr>
								";
								$j=$k;
							}
							$k++;
							$return.='<td><input type="checkbox" name="selectfield[]" value="'.$c.'">'.$c.'</td>
							';
							$m=0;
							if ($k%$itemsperrow==0 && $k!=$j)
							{
								$return.="</tr>
								"; $m=1;
							}
						}
						if ($returntype=="select")
						{
							$m=3;
							$return.='<option value="'.$c.'">'.$c.'</option>';
						}
						break;
					}
					else $i++;
				}
				
		}
		if ($m==0) $return.='</tr>';
		return $return;
	}
	//end of function that returns db fields
	
	function replace_buttons($template, $member_id, &$t)
	{
		$q2=new Cdb;
		
		include ("lib/inc.payment.functions.php"); 
		$query="select * from products";
		$q2->query($query);
		while ($q2->next_record())
		{
			if ( strpos($template, "{".$q2->f("nid")."}") === false)
			{ }
			else
			{
				$product_id=$q2->f("id");
				$aff_id=$_COOKIE["aff"];
				$session=new_sess_id(); 
				$step2=0; 
				$buttons=get_pay_buttons($member_id, $product_id, $aff_id, $session, $step2); 
				$template=str_replace("{".$q2->f("nid")."}", $buttons, $template);
				
			}
		}
		$t->set_var("content", $template);
		return true;
	}
?>