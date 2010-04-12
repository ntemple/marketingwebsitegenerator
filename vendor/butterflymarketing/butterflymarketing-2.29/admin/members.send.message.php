<?php 
	include ("inc.top.php");
	
	$t->set_file("content", "admin.members.send.message.html");
	$t->set_var("member_id", $id);
	$t->set_file("main", "admin.main.html");
	$t->set_var("sitename", SITENAME);
	
	$ocontent=$t->parse("page", "content");
	$ocontent='<script language=JavaScript src="../editor/scripts/innovaeditor.js"></script>
					<link href="../css/butterfly.css" rel="stylesheet" type="text/css">
					'.$ocontent;
		
	echo $ocontent;
		
	
?>