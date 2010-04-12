<?php 
include("inc.all.php");
	
$q=new Cdb;
if (get_setting("delete_acount") == 1){
	$q->query("DELETE from members where MD5(CONCAT('".get_setting("secret_string")."',ID))='$sess_id'");
}
header("Location: index.php");
session_destroy();
exit;
?>