<?php 	
	set_time_limit(0);
	include("inc.all.php");
	$q2=new cdb;
	$k=0;
	$query="select * from pending where subject!='already sent' order by id asc limit 0,1500";
	$q->query($query);
				
	if ($q->nf()==0) die();
	while ($q->next_record())
	{
		
		
		$to_email=$q->f("to_email");
		$subject=stripslashes($q->f("subject"));
		$body=stripslashes($q->f("body"));
		$header=$q->f("from_email");
		$id=$q->f("id");
		
		$date_snt=time();
		$query="UPDATE pending SET subject='already sent', body='$date_snt' where id='$id'";
		$q2->query($query);
		$date_del=time()+(24*60*60*3);
		$query="DELETE FROM pending WHERE subject='already sent' AND body>'$date_del'";
		$q2->query($query);
		@mail($to_email, $subject, $body, "From: ".$header);
		
	}
?>