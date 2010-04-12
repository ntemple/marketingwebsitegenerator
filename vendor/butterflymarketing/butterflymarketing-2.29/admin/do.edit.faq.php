<?php 
	include("inc.top.php");
	
	$query="update faq set question='".addslashes($question)."', answer='".addslashes($answer)."', faq_category='".addslashes($category)."', position='$position' where id='$id'";
	$q->query($query);
		
	header("location:faq.php");
	
?>