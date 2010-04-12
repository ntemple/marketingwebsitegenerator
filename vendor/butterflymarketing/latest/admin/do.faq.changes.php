<?php 
	include("inc.top.php");
	$q2=new CDB;
	$query="select id from faq";
	$q->query($query);
	while ($q->next_record())
	{
		
		$updatequery="update faq set question='".addslashes($question[$q->f("id")])."', answer='".addslashes($answer[$q->f("id")])."', position='".$position[$q->f("id")]."'  where id='".$q->f("id")."'";
		$q2->query($updatequery);
	}
	header("location:faq.php");
	include ("inc.bottom.php");
?>