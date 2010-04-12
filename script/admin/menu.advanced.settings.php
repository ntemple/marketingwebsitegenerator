<?php 
	include "inc.top.php";
	$q2=new Cdb;
	
	$t->set_file("membershiplist", "admin.menu.membership.checkboxes.html");
	
	$t->set_var("item_id", $id);
	$query="select * from menus where id='$id'";
	$q->query($query);
	$q->next_record();
	if ($q->f("menu_category")!="main")
		$t->set_file("content", "admin.menu.advanced.settings.html");
	else 
		$t->set_file("content", "admin.menu.advanced.settings.main.html");
	
	if ($q->f("active")==1) $t->set_var("activechecked", "checked");
	else $t->set_var("activechecked", "");
	
	if ($q->f("open_new_window")==1) $t->set_var("openchecked", "checked");
	else $t->set_var("openchecked", "");
	
	$query="select * from menu_permissions where menu_item='$id'";
	$q->query($query);
	$i=0;
	while ($q->next_record())
	{
		if ($q->f("membership_id")==0)
		{	
			$t->set_var("justchecked", "");
			$t->set_var("allchecked", "checked");
			$t->set_var("visibility", "");
		}	
		else
		{	
			$t->set_var("justchecked", "checked");
			$t->set_var("visibility", "none");
			$t->set_var("allchecked", "");
			
		}
	}
	if ($q->nf()==0) 
		{
			$t->set_var("allchecked", "checked");
			$t->set_var("justchecked", "");
			$t->set_var("visibility", "none");
		}
	
	$query="select id, name from membership where active=1";
	$q->query($query);
	while ($q->next_record())
	{
		$query="select id from menu_permissions where menu_item='$id' and membership_id='".$q->f("id")."'";
		$q2->query($query);
		$q2->next_record();
		if ($q2->nf()==0) $t->set_var("mchecked","");
		else $t->set_var("mchecked", "checked");
		$t->set_var("membership_id", $q->f("id"));
		$t->set_var("membership_name", $q->f("name"));
		$t->parse("membership_list", "membershiplist", true);
	}
	
	$t->set_file("main", "admin.main.empty.html");
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main");
	
?>