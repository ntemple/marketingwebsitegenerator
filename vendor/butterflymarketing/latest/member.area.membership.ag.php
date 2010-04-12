<?php 
include("inc.top.php");
	$t->set_file("content", "member.area.membership.ag.html");
	$t->set_file("item_row", "member.area.membership.ag.row.access.html"); 
	$t->set_file("membership_row", "member.area.membership.ag.row.html");
	 get_logged_info();
	 $q2=new CDB;
	 $query="SELECT id FROM menus WHERE link='member.area.membership.ag.php'";
	 $q2->query($query);
	 $q2->next_record();
	 $query="SELECT membership_id FROM menu_permissions WHERE menu_item='".$q2->f("id")."'";
	 $q2->query($query);
	 while ($q2->next_record()) {
	 	$permissions[]=$q2->f("membership_id");
	 }
	 if (count($permissions)>0) {
	 	$error='<center><font color="red"><b>You do not have access to this area!<br><br>Upgrade your membership level!</b></font></center>';
	 	foreach ($permissions as $value) {
	 		if ($value==$q->f("membership_id")) {
	 			$error='';
	 			break;
	 		}
		}
		if ($error!="") {
			die("$error");
		}
	 }
	$aff_id=$q->f("aff");
	$member_id=$q->f("id");
	$member_membership_id=$q->f("membership_id");
	updateHistory($member_id, $member_membership_id, true);
	updateHistory($member_id, get_setting("default_free"), true);
	get_logged_info();
	$member_history=explode(",", $q->f("history"));
	
foreach ($member_history as $value) {
		$query="SELECT rank FROM membership WHERE id='".$value."'";
		$q->query($query);
		$q->next_record();
		$membership_history[]=$q->f("rank");
}
	
	$show_item=array();
	
foreach ($membership_history as $value) {
	if ($value!="") {
		$show_item[]=$value;
	}
}
	
	$show_item=array_unique($show_item);
	
	$query="select * from membership where id='".$member_membership_id."' order by rank DESC";
	$q->query($query);
	$q->next_record();
	$t->set_var("membership", $q->f("name"));
	$query="select * from membership where active=1 order by rank DESC";
	$q->query($query);
	while ($q->next_record())
	{
	
		if (strpos($q->f("shown_to"),"|".$member_membership_id."|")!==false)
		{
			
			$t->set_var("id", $q->f("id"));
			$t->set_var("membershipn", $q->f("name"));
			$t->parse("upgrades", "membership_row", true);
		}
		
		if (array_search($q->f("rank"), $show_item)!==false)
		{
			$secret_level=$q->f("id");
			$t->set_var("lvl", $secret_level);
			$t->set_var("membership2", $q->f("name"));
			$t->parse("item_list","item_row",true);
		}
		
	}    
	 replace_tags_t($member_id, $t);
	 
	
include("inc.bottom.php");
?>