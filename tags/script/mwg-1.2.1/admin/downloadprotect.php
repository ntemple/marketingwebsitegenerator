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
	$q2=new CDB;
	
$chck_funtions = '';
	$t->set_file("content", "admin.download.protect.html");
	$t->set_file("membershiplist", "admin.membership.select.html");
	$t->set_file("protectedlist", "admin.downloadprotect.row.html");
	$query="select id, name from membership";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("membership_id", $q->f("id"));
		$t->set_var("membership_name", $q->f("name"));
		$t->parse("membership_list", "membershiplist", true);
	}
	 
	 $query="select * from downloadprotect";
	 $q->query($query);
	if ($q->nf() != 0) 
		 while ($q->next_record())
		 {
			$t->set_var("filename", $q->f("file"));
			$t->set_var("link", $q->f("link").".php");
			$t->set_var("memberfile", $q->f("memberfile"));
			$t->set_var("membership_id", $q->f("membership_id"));
			$t->set_var("link_for_page", '<a href="'.get_setting("site_full_url").$q->f("link").'.php">Click Here</a> to download');
			
			if ($q->f("manual")!=0)
			{
				FFileRead("template.dp.php", $phpfile);
				
	$chck_funtions .= "display_tr(document.getElementById('code_".$q->f('id')."'));";
				$manually="
				<tr bgcolor=\"#33CCCC\">
					<input type='checkbox' name='code_".$q->f('id')."' id='code_".$q->f('id')."' style='display:none'>
					<td colspan=2 name='tr_".$q->f('id')."'><label for='tr_".$q->f('id')."' style='cursor:pointer; text-decoration:underline;color:#0000FF;' onClick=\"if (document.getElementById('code_".$q->f('id')."').checked==true) {document.getElementById('code_".$q->f('id')."').checked=false} else{document.getElementById('code_".$q->f('id')."').checked=true}display_tr(document.getElementById('code_".$q->f('id')."'))\">Get Php Code</label> for the page. Please name the page ".$q->f("link").".php and upload it to the root folder of the site.</td>
				</tr>
				<tr bgcolor=\"#076C9F\"><td colspan=2 name='code_".$q->f('id')."_td' id='code_".$q->f('id')."_td'><textarea cols=\"90\" rows=\"10\">".str_replace("<?php", "&lt;?php", $phpfile)."</textarea></td></tr>";
				$t->set_var("manually", $manually);
			}
			else
			{
				$t->set_var("manually", "");
			}
			$t->parse("protected_list", "protectedlist", true);
			
		 }
	else $t->set_var("protected_list","");
	 $t->set_var("chck_funtions",$chck_funtions);
	include("inc.bottom.php");
?>