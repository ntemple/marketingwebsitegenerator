<?php
	include ("inc.top.php");
	if ($cycle!='' && $text !=''){
	$query="insert into cycle (cycle, text, file) values ('$cycle', '$text', '$file')";
	$q->query($query);
}
	header("location:cycler.php");
?>