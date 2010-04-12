<?php 
	include("inc.top.php");
	
	$query="insert into faq (id, faq_category, question, answer, position) values (NULL, '".addslashes($faq_category)."', '".addslashes($question)."','".addslashes($answer)."', '$position')";
	$q->query($query);
	header("location:faq.php");
	
	include('inc.bottom.php');
?>