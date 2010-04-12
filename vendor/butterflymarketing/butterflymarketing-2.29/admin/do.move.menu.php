<?php 
	include("inc.top.php");
	$q2=new CDB;
	$q3=new CDB;
	if ($move == "down"){
		$i = 0;
		$q2->query("select * from menus where position >= $rank AND menu_category='".$_GET['menu_type']."' order by position asc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("position");
				$menu_category_old = $q2->f("menu_category");
				$name_old = $q2->f("name");
				$link_old = $q2->f("link");
				$open_new_window_old = $q2->f("open_new_window");
				$active_old = $q2->f("active");
				$alogin_old = $q2->f("alogin");
				$id_old = $q2->f("id");
			
			}elseif($i == 2){
				$q2->query("UPDATE menu_permissions SET menu_item='0' WHERE menu_item='".$q2->f("id")."'");
				$q2->query("UPDATE menu_permissions SET menu_item='".$q2->f("id")."' WHERE menu_item='$id_old'");
				$q2->query("UPDATE menu_permissions SET menu_item='$id_old' WHERE menu_item='0'");
				$q2->query("UPDATE menus SET position='".$q2->f("position")."', menu_category='$menu_category_old', name='$name_old', link='$link_old', open_new_window='$open_new_window_old', active='$active_old', alogin='$alogin_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE menus SET position='$rank_old', menu_category='".$q2->f("menu_category")."', name='".$q2->f("name")."', link='".$q2->f("link")."', open_new_window='".$q2->f("open_new_window")."', active='".$q2->f("active")."', alogin='".$q2->f("alogin")."' WHERE id=$id_old");
			}else break;
			
		}
	}elseif ($move == "up"){
		$i = 0;
		$q2->query("select * from menus where position <= $rank AND menu_category='".$_GET['menu_type']."' order by position desc");
		while ($q2->next_record()){
			$i++;
			if ($i == 1){
				$rank_old = $q2->f("position");
				$menu_category_old = $q2->f("menu_category");
				$name_old = $q2->f("name");
				$link_old = $q2->f("link");
				$open_new_window_old = $q2->f("open_new_window");
				$active_old = $q2->f("active");
				$alogin_old = $q2->f("alogin");
				$id_old = $q2->f("id");
				
			}elseif($i == 2){
				$q2->query("UPDATE menu_permissions SET menu_item='0' WHERE menu_item='".$q2->f("id")."'");
				$q2->query("UPDATE menu_permissions SET menu_item='".$q2->f("id")."' WHERE menu_item='$id_old'");
				$q2->query("UPDATE menu_permissions SET menu_item='$id_old' WHERE menu_item='0'");
				
				$q2->query("UPDATE menus SET position='".$q2->f("position")."', menu_category='$menu_category_old', name='$name_old', link='$link_old', open_new_window='$open_new_window_old', active='$active_old', alogin='$alogin_old' WHERE id='".$q2->f("id")."'");
				$q2->query("UPDATE menus SET position='$rank_old', menu_category='".$q2->f("menu_category")."', name='".$q2->f("name")."', link='".$q2->f("link")."', open_new_window='".$q2->f("open_new_window")."', active='".$q2->f("active")."', alogin='".$q2->f("alogin")."' WHERE id=$id_old");
			}else break;
			
		}
	}
	header("Location: menu.php");
	exit;
?>