<?php 
	include("inc.top.php");
	$from=$from_name." <".$from_email.">";
	if ($filter)
	{
		$query="insert into autoresponders (from_email, subject, header, body, footer, membership, days, filter, sendby) values ('".addslashes($from)."', '".addslashes($subject)."','".addslashes($header)."','".addslashes($body)."','".addslashes($footer)."','$membership','$days','".addslashes($filter)."', '$sendby')";
		$q->query($query);
	}
	else
	{
		$query="insert into autoresponders (from_email, subject, header, body, footer, membership, days, sendby) values ('".addslashes($from)."', '".addslashes($subject)."','".addslashes($header)."','".addslashes($body)."','".addslashes($footer)."','$membership','$days', '$sendby')";
		$q->query($query);
	}
	header("location:autoresponder.php");	
?>