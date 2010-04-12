<?php 
	
	include("inc.top.php");
	
	
	// download bonuses page
	$q->query("SELECT max(rank) AS rank_max FROM membership");
	$q->next_record();
	
	$query="insert into membership (name, rank) values ('$membership_name', '".($q->f("rank_max")+1)."')";
	$q->query($query);
	$mid=mysql_insert_id($q->link_id());
	$mname=$membership_name;
	$filename="member.area.membership.dw.".$mid;
	
	if (is_file("../templates/".$filename.".ag.html"))
	{
		die("../templates/".$filename.".ag.html file already exists, not overwriting, please enter another filename");
	}
	FFileWriteNew("../templates/".$filename.".ag.html", $membership_file, "w");
	$query="insert into templates (id, filename, name, description) values
			(NULL, '".$filename.".ag.html', 'Template Bonus for membership $mname', '$title')";
	$q->query($query);
	$tid=mysql_insert_id($q->link_id());
	// salespage
	$filename="member.area.membership.sl.".$mid;
	
	if (is_file("../templates/".$filename.".ag.html"))
	{
		die("../templates/".$filename.".ag.html file already exists, not overwriting, please enter another filename");
	}
	FFileWriteNew("../templates/".$filename.".ag.html", $membership_file, "w");
	$query="insert into templates (id, filename, name, description) values
			(NULL, '".$filename.".ag.html', 'Template Salespage for $mname', '$title')";
	$q->query($query);
	$tid2=mysql_insert_id($q->link_id());
	// the new menu item
	
	
	$query="update membership set template_id='$tid', template_id2='$tid2', promo_code='$promo_code' where id='$mid'";
	$q->query($query);
	header("Location: membership.php");
	
?>