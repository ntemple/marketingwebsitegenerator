<?php
	include("inc.top.php");
$q->query("SELECT * FROM twitter");
$err="";
if($q->nf()<50 ){
	if(strlen($tweet)<=140)
		$q->query("INSERT INTO twitter SET tweet='".addslashes($tweet)."'");
	else $err="?err=2";
}else $err="?err=1";
header("location:twitter.php".$err);	
?>