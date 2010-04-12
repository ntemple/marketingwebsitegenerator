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

 
include("inc.all.php");
$q2=new Cdb;
	if (get_setting("send_mail")){
		get_logged_info(); //member area init...
		$user_id=$q->f("id");
		$lastemail=$q->f("last_mail");
		
		$allowed=get_setting("mail_interval");
	
		$lastdate=explode("-", $lastemail);
		
		$laststamp=mktime(0,0,0, $lastdate[1], $lastdate[2], $lastdate[0]);
		$interval=$allowed*88400;
		$nextemail=$laststamp+$interval;
	
		if ($nextemail < time()) {
		
		$user_id = $q->f("id");
		$email=$q->f("email");
		$first = $q->f("first_name"); 
		$last = $q->f("last_name");
		$query="update members set last_mail=NOW() where id='$user_id'";
		
		$q->query($query);
		$query="select * from members where aff='".$user_id."'";
		$q->query($query);
		$from = "From: ".$first." " .$last."<".$email.">\r\n";		
		
		$max_level = get_setting("mail_levels");
		
		if ($max_level){
			while ($q->next_record()){
				$query="select * from members where aff='".$user_id."' AND unsub_downline!=1";
				$q->query($query);
				 
				while ($q->next_record())
				{
					$link_unsub = "\n To stop recieving emails from your affiliate click <a href='".get_setting('site_full_url').'unsub_downline.php?code='.md5(get_setting("secret_string")."-".$q->f('id'))."'>here</a>";
					
					ReplaceTags($body,$q->f("id"),$body_repl);
					$body_repl = str_replace('[[unsub_link]]',get_setting('site_full_url').'unsub_downline.php?code='.md5(get_setting("secret_string")."-".$q->f('id')),$body_repl);
					ReplaceTags($subject,$q->f("id"),$subj_repl);
					if (get_setting("allow_private_messages") && $sendvia==2)
					{
						
						$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('".$q->f("id")."', '$user_id', '$subj_repl', '$body_repl', NOW(), NOW())";
						$q2->query($query);
					}else{
						$match = strstr($body_repl, get_setting('site_full_url')."unsub_downline.php?code=");
						if (!$match){
							$body_repl .= $link_unsub;
	
						}
						mail($q->f("email"), $subj_repl, $body_repl, $from);
					}
		
				}
					
			}
		}
		count_levels($user_id,1);
		
		$i = 0;
		$k = 0;
		if (!empty($lvl_mat) && get_setting("mail_levels")>1){
			foreach ($lvl_mat as $lvl){
				$i++;
				foreach ($lvl as $aff_id){
					$query="select * from members where aff='".$aff_id."' AND unsub_downline!=1";
					$q->query($query);
					while ($q->next_record())
					{
						$link_unsub = "\n To stop recieving emails from your affiliate click <a href='".get_setting('site_full_url').'unsub_downline.php?code='.md5(get_setting("secret_string")."-".$q->f('id'))."'>here</a>";
						ReplaceTags($body,$q->f("id"),$body_repl);
					$body_repl = str_replace('[[unsub_link]]',get_setting('site_full_url').'unsub_downline.php?code='.md5(get_setting("secret_string")."-".$q->f('id')),$body_repl);
						ReplaceTags($subject,$q->f("id"),$subj_repl);
						if (get_setting("allow_private_messages") && $sendvia==2)
						{
							$query="insert into messages (member_id, from_member_id, subject, body, time_sent, date_sent) values ('".$q->f("id")."', '$user_id', '$subj_repl', '$body_repl', NOW(), NOW())";
						$q2->query($query);
						}
						$match = strstr($body_repl, get_setting('site_full_url')."unsub_downline.php?code=");
						if (!$match){
							$body_repl .= $link_unsub;
						}
						mail($q->f("email"), $subj_repl, $body_repl, $from);
					}
				}
			}
		}
	}
		else {
			$a=date("m/d/Y", $nextemail);
			header("location:member.area.downline.php?msg=".urlencode("You are not allowed to email again until ".$a));
			die(); 
			}
}
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
	header("location:member.area.downline.php?msg=".urlencode("The task has been completed"));
	exit;
include("inc.bottom.php");
?>