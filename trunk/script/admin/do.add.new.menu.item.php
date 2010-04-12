<?php 
	include("inc.top.php");
	
	$q2 = new CDb();
	$q2->query("SELECT MAX(position) AS maxim FROM menus");
	$q2->next_record();
	$item_position = $q2->f("maxim")+1;
	
	if ($item_category=="main" || $item_category=="members")
	$query="insert into menus (name, link, menu_category, position, open_new_window) values ('".addslashes($item_name)."', '$item_link', '$item_category','$item_position','$open_new_window')";
	else 
	if ($item_category==0)
		{
			$query="insert into menus (name, link, menu_category, position, open_new_window) values ('".addslashes($item_name)."', '$item_link', 'main','$item_position','$open_new_window')";
			$q->query($query);
			$query="insert into menus (name, link, menu_category, position, open_new_window) values ('".addslashes($item_name)."', '$item_link', 'members','$item_position','$open_new_window')";
		}
	$q->query($query);
	header("location:menu.php");
	
?>