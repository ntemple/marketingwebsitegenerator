<?php
include("inc.all.php");
if ($_POST['activ_code']==get_setting("activation_code_email"))
	{$code=$_POST['activ_code'];
	get_logged_info();
	$query="update members set active=1 where id='".$q->f("id")."'";
	$q->query($query);
	header("location:member.area.in.php");
	}else{ header("location:activation.php?errorcode=1");	
		}
?>