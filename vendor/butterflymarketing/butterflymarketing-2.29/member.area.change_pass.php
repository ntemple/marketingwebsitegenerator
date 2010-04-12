<?php 
include("inc.top.php");
$q2=new CDB;
get_logged_info(); //member area init...
	$t->set_file("content", "member.area.change_pass.html");
	if ($err == 1) $t->set_var("error","Please retype the old password");
	elseif ($err == 2) $t->set_var("error","The two passwords do not match");
    elseif ($err == 3) $t->set_var("error", "Thank You. Your Password Has Been Changed.");
	else $t->set_var("error","");
include("inc.bottom.php");
?>
