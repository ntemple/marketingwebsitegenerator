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
	$q2=new CDB;
	$t->set_file("content", "admin.membership.html");
	$t->set_file("membershiplist", "admin.membership.item.html");
		$t->set_var("sel_profile", "");
		$t->set_var("sel_signup", "");
		$t->set_var("sel_both", "");
		$t->set_var("sel_none", "");
	if (get_setting("show_promo_signup")&& get_setting("show_promo_profile"))
	{
		$t->set_var("sel_both", "selected");
	}
	if (get_setting("show_promo_signup")==0 && get_setting("show_promo_profile")==0)
	{
		$t->set_var("sel_none", "selected");
	}
	if (get_setting("show_promo_signup"))
	{
		$t->set_var("sel_signup", "selected");
	}
	if (get_setting("show_promo_profile"))
	{
		$t->set_var("sel_profile", "selected");
	}
	$query="select * from membership order by rank asc";
	$q->query($query);
	$nr_fields = $q->num_rows();
	$i = 0;
	while ($q->next_record())
	{
		$checkbox='';
		$shown_to=explode("|",$q->f("shown_to"));
		foreach ($shown_to as $b)
		$query="select id, name from membership where active=1 and id!= ".$q->f("id")." and rank < ".$q->f("rank")." order by rank asc";
		$q2->query($query);
		while ($q2->next_record())
		{
			if (array_search($q2->f("id"), $shown_to)==true)
			{
				$checkbox.='<input name="display_to'.$q->f("id").'[]" type="checkbox" value="'.$q2->f("id").'" checked>'.$q2->f("name");
			}
			else 
			{ 
				$checkbox.='<input name="display_to'.$q->f("id").'[]" type="checkbox" value="'.$q2->f("id").'">'.$q2->f("name");
			}
		}
		$t->set_var("membership_checkboxes", $checkbox);
		$query="select * from membership where rank<".$q->f("rank");
		$q2->query($query);
		if ($q2->nf()!=0) $t->set_var("membership_checkboxes_description", '<span style="background-color: #ECFFFF">Select (check on) what membership a user should have in order to UPGRADE to this membership:
</span> <span style="background-color: #ECFFFF"><b>{membership_name} </b>membership.</span><span style="background-color: #ECFFFF"> An option to upgrade to  
</span> <b><span style="background-color: #ECFFFF">{membership_name}  </span> </b><span style="background-color: #ECFFFF">membership will will only show as an UPGRADE option to the following checked members. If checked below, they can upgrade when they click on | Membership | when they are logged in.
</span>');
		else $t->set_var("membership_checkboxes_description", "");
		$i++;
		$query="select ref_no from membership where id='".$q->f("id")."'";
		$q2->query($query);
		if ($q2->nf()==0) $t->set_var("referral", "0");
		else 
		{
			$q2->next_record();
			if ($q2->f("ref_no")!="") $t->set_var("referral", $q2->f("ref_no"));
			else $t->set_var("referral", "0");
		}
		$t->set_var("membership_id", $q->f("id"));
		$t->set_var("membership_name", $q->f("name"));
		$t->set_var("template_id", $q->f("template_id"));
		$t->set_var("rank", $q->f("rank"));
		$t->set_var("promo", $q->f("promo_code"));
		$t->set_var("template_id2", $q->f("template_id2"));
		if ($q->f("active")==1) 
		{
			$active=" <font color=green><strong>Active</strong></font> - <a href='do.membership.active.php?id=".$q->f("id")."'>De-Activate</a>";
		}
		else
		{
			$active=" <font color=red><strong>NOT Active</strong></font> - <a href='do.membership.active.php?id=".$q->f("id")."'>Activate</a>";
		}
		$t->set_var("active", $active);
		$query="select filename from templates where id='".$q->f("template_id")."'";
		$q2->query($query);
		$q2->next_record();
		$t->set_var("template_name", $q2->f("filename"));
		
		if ($i == 1){
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=down')\"/>";
		}elseif ($i == $nr_fields){
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=up')\"/>";
		}else{
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=down')\"/>&nbsp;<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=up')\"/>";
			
		}
		
		$t->set_var("link_move", $link_move);
		$t->parse("membership_list", "membershiplist", true);
		$t->unset_var("membership_checkboxes");
	}
	if ($q->nf()==0) $t->set_var("membership_list", "");
	
	GetPayButtonsList($t);
	
	GetTags($tags);
	if (strlen($tags)==0) $t->set_var("tag_list", "");
	else
	{
		$t->set_var("tag_list", $tags);
	}
	include("inc.bottom.php");
?>