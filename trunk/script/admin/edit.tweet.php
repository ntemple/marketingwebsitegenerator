<?php 
	include("inc.top.php");
if(strlen($tweet)<=140){
	$q->query("UPDATE twitter set tweet='".$tweet."' WHERE id='".$id."'");
	$err="?save=ok";
}else{
	$err="?err=2";
}
header("location:twitter.php".$err);echo "<script>alert('dede');<script>";
	
?>