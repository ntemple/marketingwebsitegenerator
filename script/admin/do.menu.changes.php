<?php 
	include ("inc.all.php");
	$q2=new CDB;
	$query="update menus set alogin=1 where id='$afterlogin'";
	$q->query($query);
	$query="update menus set alogin=0 where id!='$afterlogin'";
	$q->query($query);
	$query="select id, alogin from menus";
	$q->query($query);
	while ($q->next_record())
	{
		$updatequery="update menus set name='".addslashes($name[$q->f("id")])."', link='".$link[$q->f("id")]."', position='".$position[$q->f("id")]."' where id='".$q->f("id")."'";
		$q2->query($updatequery);
	
	}
	$query="select distinct menu_category from menus";
	$q->query($query);
	while ($q->next_record())
	{
		$update="update settings set value='".$_POST["verticalmenu".$q->f("menu_category")]."' where name='verticalmenu".$q->f("menu_category")."'";
		$q2->query($update);
	}
	header("location:menu.php");
	include ("inc.bottom.php");
?>