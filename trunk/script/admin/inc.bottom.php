<?php 
	if ($_GET['menu'] == "settings"){
		$_SESSION['menu'] = "settings";
	}elseif ($_GET['menu'] == "members"){
			$_SESSION['menu'] = "members";
	}elseif ($_GET['menu'] == "design"){
			$_SESSION['menu'] = "design";
	}elseif ($_GET['menu'] == "membership"){
			$_SESSION['menu'] = "membership";
	}elseif ($_GET['menu'] == "help"){
			$_SESSION['menu'] = "help";
	}elseif ($_GET['menu'] == "updates"){
			$_SESSION['menu'] = "updates";
	}
	$t->set_file("main", "admin.main.".$_SESSION['menu'].".html");
	
	$query="select id from messages where member_id=1 and read_flag=0";
	$q->query($query);
	$q->next_record();
	FFileRead("../config/version", $version);
	$t->set_var("version", $version);
	$t->set_var("newmessages", $q->nf());
	$t->set_var("sitename", SITENAME);
	$t->set_var("year", date("Y"));
	$ocontent=$t->parse("page", "content");
	if ($notemplate)
	{
		if ($from) 
		{
			$ocontent=str_replace("{from}", "?from=".$from, $ocontent);
			$_SESSION["from"] = $from;
		}
		$ocontent='<script language=JavaScript src="../editor/scripts/innovaeditor.js"></script>
					<link href="../css/butterfly.css" rel="stylesheet" type="text/css">'.$ocontent;
		
		echo $ocontent;
		$_SESSION["notemplate"] = $notemplate;
	}
	else
	{
		$t->set_var("content", $ocontent);
		$t->pparse("out", "main");
	}	
?>