<?php 
	include("inc.top.php");
	$q2=new Cdb;
	$query="select * from signup_settings";
	$q->query($query);
	while ($q->next_record())
	{	
		
		if ($required[$q->f("id")]){
			$atsignup[$q->f("id")] = 1;
			$membersarea[$q->f("id")] = 1;
		}elseif ($atsignup[$q->f("id")]){
			$atsignup[$q->f("id")] = 1;
			$membersarea[$q->f("id")] = 1;
		}
		if (($q->f("field") == "email") || ($q->f("field") == "password")){
			$atsignup[$q->f("id")] = 1;
			$membersarea[$q->f("id")] = 1;
			$required[$q->f("id")] = 1;
		}
		$query="update signup_settings set description='".$_POST[$q->f("field")]."', atsignup='".$atsignup[$q->f("id")]."', required='".$required[$q->f("id")]."', membersarea='".$membersarea[$q->f("id")]."' where id='".$q->f("id")."'";
		$q2->query($query);
		
	}
	header("location:signup.settings.php");
?>