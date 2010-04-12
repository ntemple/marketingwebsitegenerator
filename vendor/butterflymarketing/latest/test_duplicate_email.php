<?php 
	include("inc.top.php");
	$querystring = '';
	
	$query="select * from autoresponder_config where arp_id='".get_setting("arp_in_use")."' order by id";
	$q->query($query);
	while($q->next_record()){
		if ($q->f('field') == 'email') $email = $q->f('value');
	}
	
	$q->query("SELECT email FROM members");
	while($q->next_record()){
		if ($q->f('email') == $$email){
			$querystring = 'double_email=1';
			break;
		}else{
			$querystring = 'double_email=0';
		}
	}
	
	foreach ($HTTP_GET_VARS as $name => $value){
		$querystring .= "&$name=$value";
	}
	
	header("Location: signup.php?$querystring");
	?>