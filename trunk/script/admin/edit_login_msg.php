<?php 
	
	include("inc.top.php");
	$t->set_file("content", "admin.edit_login_msg.html");
	$query="select message from after_login WHERE id='$id'";
	$q->query($query);	
	$q->next_record();
	$t->set_var("message",stripslashes($q->f('message')));
	$t->set_var("id",$id);
	
	$t->set_file("main", "admin.main.empty.html");
	
	
	$ocontent=$t->parse("page", "content");
			$ocontent='<script language=JavaScript src="../editor/scripts/innovaeditor.js"></script>
					<link href="../css/butterfly.css" rel="stylesheet" type="text/css">'.$ocontent;
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main"); 
?>