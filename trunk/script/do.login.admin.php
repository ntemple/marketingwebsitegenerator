<?php 
include("admin/inc.top.php");
if (strlen($password) == 0) {
	die('Invalid username or password');
}
$query="select * from members where email='$email' and password='$password'";
$q->query($query);
if ($q->nf()==0)
{
	$t->set_file("content", "do.login.error.html");
	include("inc.bottom.php");
}
else
{
	$q->next_record();
	
	$sess_id=md5(get_setting("secret_string").$q->f("id"));
		
	$_SESSION["sess_id"] = $sess_id;
	
	setcookie("emailx",$q->f("email"),time()+99999);
	
	
	header("Location: member.area.in.php");
	
}
?>