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
	get_logged_info(); //member area init...
	if (get_setting("view_downline")){
		
	
		$user_id = $q->f("id");
		$email=$q->f("email");
	
		$t->set_file("content", "member.area.downline.html");
		$t->set_file("downline_row_file", "member.area.downline.rows.html");
		$t->set_file("downline_form_file", "member.area.email.downline.html");
		$t->set_file("allowprivatemessages", "email.downline.priv.msg.html");
		if (get_setting("downline_em")) $t->set_var("display_email", "<td bgcolor=\"#CCCCCC\"><strong>Email</strong></td>");
		else $t->set_var("display_email", "");
		$query="select * from members where aff='".$user_id."'";
		$q->query($query);
		$max_level = get_setting("view_downline_levels");
		if (!$q->num_rows()) 
			$t->set_var("downline_rows","<tr><td>There are no referrals</td></tr>");
		
		$j = 0;
		if ($max_level){
			while ($q->next_record())
				{
					$j++;
					if ($j == 1)  $t->set_var("nr_lvl", '					
					<tr>
								<td colspan="3" bgcolor=#efefef>Level 1</td>
					</tr>
					');
					else  $t->set_var("nr_lvl", "");
					$t->set_var("id", $q->f("id"));
					$name = $q->f("first_name")." ".$q->f("last_name");
					$t->set_var("name", $name);
					if (get_setting("downline_em")) $t->set_var("email", "<td>".$q->f("email")."</td>");
					else $t->set_var("email", "");
		
					$t->parse("downline_rows", "downline_row_file", true);
					
				}
		
			count_levels($user_id,1);
			
			$i = 0;
			$k = 0;
			if (count($lvl_mat) && get_setting("view_downline_levels")>1){
				foreach ($lvl_mat as $lvl){
					$i++;
					foreach ($lvl as $aff_id){
						$query="select * from members where aff='".$aff_id."'";
						$q->query($query);
						 
						while ($q->next_record())
						{
							
							if ($i != $k){
								$k = $i;
								$t->set_var("nr_lvl", '					
							<tr>
										<td colspan="3" bgcolor=#efefef>Level '.($i+1).'</td>
							</tr>
							');
							}else  $t->set_var("nr_lvl", "");
		
							$t->set_var("id", $q->f("id"));
							$name = $q->f("first_name")." ".$q->f("last_name");
							$t->set_var("name", $name);
							if (get_setting("downline_em")) $t->set_var("email", "<td>".$q->f("email")."</td>");
								else $t->set_var("email", "");
							
				
							$t->parse("downline_rows", "downline_row_file", true);
						}
					}
				}
			}
		}
		
		if (get_setting("send_mail")){
			GetTags($tags,"[[]]");
			$t->set_var("tag_list", $tags);
			$t->set_var("email", $email);
			
			if (get_setting("allow_private_messages"))
			{
				$t->parse("allow_private_messages", "allowprivatemessages");
			}
			$t->parse("form", "downline_form_file");
		}else{
			$t->set_var("form", "");
		}
	}else{
		$t->set_var("content","You are not allowed to view this page");
	}
	$t->set_var("msg", $msg);
include("inc.bottom.php");
function count_levels($id, $level)
{
        global $lev, $max_level, $lvl_mat;
        $q = new Cdb;
        $query="select id from members where aff='$id'";
        $q->query($query);
        $lev[$level]+=$q->nf();
        while ($q->next_record()){
      		$lvl_mat[$level][] += $q->f("id");
        }
        if ($level+1 <= $max_level-1){
	        $query="select id from members where aff='$id'";
	        $q->query($query);
        	while ($q->next_record()){
	                count_levels($q->f("id"), $level+1);
	        }
        }
}
?>