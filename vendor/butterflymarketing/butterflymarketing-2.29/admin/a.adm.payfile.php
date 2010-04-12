<?php 
	include("inc.top.php");
	
	$q=new Cdb;
	$q2=new Cdb;
	$q3=new Cdb;
	$q4=new Cdb;
	
	$fields_arr = array();
	$header = '';
	
	if($profile){
		$query="select * from signup_settings where membersarea=1 order by position asc";
		$q2->query($query);
		while ($q2->next_record()) {
			if ($q2->f('field') != "paypal_email" && $q2->f('field') != "password"){
				$fields_arr[] = $q2->f('field');
				$header .= $q2->f('field')."\t";
			}
		}
	}
	
	$query="select distinct member_id from a_tr order by member_id";
	$q->query($query);
	while ($q->next_record())
	{
 		$st="";
 		$profiles='';
 		$query="select sum(amount) as n from a_tr where member_id='".$q->f("member_id")."' and status=1";
		$q3->query($query);
		$q3->next_record();
		if ($q3->f("n")>0)
		{
			$query="select * from members where id='".$q->f("member_id")."'";
			$q4->query($query);
			$q4->next_record();
			foreach ($fields_arr as $key=>$value){
				$profiles .= $q4->f($value)."\t";
			}
			$profile = substr($profile,0,-2);
			if($include_login_emails==1 && $q4->f("paypal_email")==''){
				$ff.=$q4->f("email")."\t".(substr($q3->f("n"),0,strlen($q3->f("n"))-2))."\t".get_setting('paypal_currency')."\t$profiles\n";	
				
			}else
				$ff.=$q4->f("paypal_email")."\t".(substr($q3->f("n"),0,strlen($q3->f("n"))-2))."\t".get_setting('paypal_currency')."\t$profiles\n";	
		}
	}
	
	$date=date("m").date("d").date("y");
	$site=strtoupper(substr(get_setting('site_full_url'),7,10));
	$filename_for_user = "mass_pay_".$site."_".$date.".txt";
	header ("Content-Type: application/octet-stream"); 
	header ("Content-Length: " . strlen($ff)); 
	header ("Content-Disposition: attachment; filename=$filename_for_user"); 
	echo $ff;
?>
