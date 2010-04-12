<?php
	include "inc.top.php";
	$q2=new CDB;
	$t->set_file("content", "admin.paybutton.images.html");
	$t->set_var("product_id", $id);
	$query="select * from products where id='$id'";
	$q->query($query);
	$q->next_record();
	$t->set_var("product_name", $q->f("display_name"));
	$t->set_file("current", "admin.product.buybutton.current.images.htm");
	if ($q->f("cb_but")!=0)
	{
		$query="select * from buybuttons where id='".$q->f("cb_but")."'";
		$q2->query($query);
		$q2->next_record();
		if ($q2->f("url")==0) $t->set_var("image_image", '<img src="../images/buybuttons/'.$q2->f("image").'">');
		else $t->set_var("image_image", '<img src="'.urldecode($q2->f("image")).'">');
		$t->set_var("image_processor", "Image used for ClickBank");
		$t->parse("current_list","current", true);
	}
	else 
	{
		$t->set_var("image_image", '');
		$t->set_var("image_processor", "No image set for Clickbank, using default");
		$t->parse("current_list","current", true);
	}
	$t->unset_var("image_image");
	$t->unset_var("image_processor");
	if ($q->f("pp_but")!=0)
	{
		$query="select * from buybuttons where id='".$q->f("pp_but")."'";
		$q2->query($query);
		$q2->next_record();
		if ($q2->f("url")==0) $t->set_var("image_image", '<img src="../images/buybuttons/'.$q2->f("image").'">');
		else $t->set_var("image_image", '<img src="'.urldecode($q2->f("image")).'">');
		$t->set_var("image_processor", "Image used for Paypal");
		$t->parse("current_list","current", true);
		
	}
	else 
	{
		$t->set_var("image_image", '');
		$t->set_var("image_processor", "No image set for Paypal, using default");
		$t->parse("current_list","current", true);
	}
	$t->unset_var("image_image");
	$t->unset_var("image_processor");
	if ($q->f("2co_but")!=0)
	{
		$query="select * from buybuttons where id='".$q->f("2co_but")."'";
		$q2->query($query);
		$q2->next_record();
		if ($q2->f("url")==0) $t->set_var("image_image", '<img src="../images/buybuttons/'.$q2->f("image").'">');
		else $t->set_var("image_image", '<img src="'.urldecode($q2->f("image")).'">');
		$t->set_var("image_processor", "Image used for 2Checkout");
		$t->parse("current_list","current", true);
	}
	else 
	{
		$t->set_var("image_image", '');
		$t->set_var("image_processor", "No image set for 2Checkout, using default");
		$t->parse("current_list","current", true);
	}
	if ($q->f("auth_but")!=0)
	{
		$query="select * from buybuttons where id='".$q->f("auth_but")."'";
		$q2->query($query);
		$q2->next_record();
		if ($q2->f("url")==0) $t->set_var("image_image", '<img src="../images/buybuttons/'.$q2->f("image").'">');
		else $t->set_var("image_image", '<img src="'.urldecode($q2->f("image")).'">');
		$t->set_var("image_processor", "Image used for Authorize.net");
		$t->parse("current_list","current", true);
	}
	else 
	{
		$t->set_var("image_image", '');
		$t->set_var("image_processor", "No image set for Authorize.net, using default");
		$t->parse("current_list","current", true);
	}
$t->unset_var("image_image");
	$t->unset_var("image_processor");
	
	$t->set_file("main", "admin.main.empty.html");
	
	
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main"); 
?>