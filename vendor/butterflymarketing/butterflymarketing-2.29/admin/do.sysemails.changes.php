<?php 
	include("inc.top.php");
	//Building Query for Settings Update
	$q2=new CDB;
	
	$i = 0;
	foreach ($_POST as $variable){
		$i = 1;
	}
	
	$k=1;
	
	$query="select * from settings where name like '%_email%' and box_type!='hidden' and id!=13 and id!=9 order by cat, rank";
	$q->query($query);
	if ($i){
		while ($q->next_record())
		{
				$updatequery="update settings set value='".addslashes($_POST[$q->f("name")])."' where name='".$q->f("name")."'";
				$q2->query($updatequery);
			
				
		}
	}
	header("location:sysemails.php");
?>