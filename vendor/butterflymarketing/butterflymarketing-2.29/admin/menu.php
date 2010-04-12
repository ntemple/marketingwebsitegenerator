<?php 
	include("inc.top.php");
	$q2=new CDB;
	$q3=new CDB;
	$t->set_file("content", "admin.menu.html");
	$t->set_file("menuitems", "admin.menu.items.html");
	$t->set_file("menucategory", "admin.menu.category.row.html");
	$t->set_file("menuvertical", "admin.menu.category.row.vertical.menu.html");
	$t->set_file("menucatdesc", "admin.menu.category.row.desc.html");
	$query="select * from menus WHERE menu_category='members' order by position asc";
	$q->query($query);
	$total_members = $q->nf();
	$query="select * from menus WHERE menu_category='main' order by position asc";
	$q->query($query);
	$total_main = $q->nf();
	
	$query="select * from menus order by menu_category asc, position asc";
	$q->query($query);
	$category='';
	$first_members = 0;
	$first_main = 0;
	while ($q->next_record())
	{
		if ($category!=$q->f("menu_category"))
		{
			$category=$q->f("menu_category");
			$t->set_var("menu_category", "<h3>".$category."</h3>");
			$t->parse("menu_list", "menucategory", true);
			
			if ($category=="main"){ $t->set_var("category_description", "This will appear to visitors which aren't logged in");
			}else{ $t->set_var("category_description", "This will appear to members which are logged in");}
			$t->parse("menu_list", "menucatdesc", true);
			
			$t->set_var("category_name", $category);
			if (get_setting("verticalmenu".$category)==1) $t->set_var("checked", "checked");
			else $t->set_var("checked", "");
			$t->parse("menu_list", "menuvertical", true);
		}
		if ($category=="members"){
			$first_members++;
			if ($q->f("alogin")==1) $t->set_var("afterlogin","<input type=radio name=afterlogin value=".$q->f("id")." checked>Member is taken to this page after login");
			else $t->set_var("afterlogin","<input type=radio name=afterlogin value=".$q->f("id").">Member is taken to this page after login");
		}else{$first_main++; $t->set_var("afterlogin", "");}
		
		if ($first_members == 1 || $first_main == 1){
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.menu.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=down&menu_type=".$q->f("menu_category")."')\"/>";
		}elseif ($first_members == $total_members || $first_main == $total_main){
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.menu.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=up&menu_type=".$q->f("menu_category")."')\"/>";
		}else{
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.menu.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=down&menu_type=".$q->f("menu_category")."')\"/>&nbsp;<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.menu.php?id=".$q->f("id")."&rank=".$q->f("position")."&move=up&menu_type=".$q->f("menu_category")."')\"/>";
		}
		$t->set_var("link_move", $link_move);
		if ($first_main == $total_main){
			$first_main = 0;
		}
			
		
		$menu_item=stripslashes($q->f("name"));
		$menu_item_link=$q->f("link");
		$menu_item_position=$q->f("position");
		$menu_item_id=$q->f("id");
		
		$query="select * from menu_permissions where menu_item='".$q->f("id")."'";
		$q2->query($query);
		$display='';
		$i=1;
		while ($q2->next_record())
		{
			
			if ($q2->f("membership_id")!=0)
			{
				$query="select name from membership where id='".$q2->f("membership_id")."'";
				$q3->query($query);
				$q3->next_record();
				if ($i==1)
				{
					$display.=$q3->f("name");
					$i++;
				}
				else $display.=", ".$q3->f("name");
			}
			else $display='all';
		}
	
		if ($q2->nf()==0) $t->set_var("permission", "all");
		else $t->set_var("permission", $display);
		
		if ($q->f("active")==1) $t->set_var("display", "<font color=green>Yes</font>");
		else $t->set_var("display", "<font color=red>No</font>");
		
		if ($q->f("open_new_window")==1) $t->set_var("open", "<font color=green>Yes</font>");
		else $t->set_var("open", "<font color=red>No</font>");
		
		$t->set_var("menu_item", $menu_item);
		$t->set_var("menu_item_link", $menu_item_link);
		$t->set_var("menu_item_position", $menu_item_position);
		$t->set_var("menu_item_id", $menu_item_id);
		
		if ($q->f("menu_category")!="main")
		{
			$query="select count(*) as a from membership";
			$q2->query($query);
			$q2->next_record();
		
			$height=180+$q2->f("a")*30;
			$width=410;
		}
		else
		{
			$height=120;
			$width=410;
		}
		$t->set_var("width", $width);
		$t->set_var("height", $height);
		
		$t->parse("menu_list", "menuitems", true);
	}
	if ($q->nf()==0) $t->set_var("menu_list", "");
	
	include("inc.bottom.php");
?>