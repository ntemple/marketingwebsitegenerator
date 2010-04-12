<?php 
include("inc.all.php");
  
  $t->set_file("content","payment.ty.html");
  
  $session = str_replace('/', '', $GLOBALS['PATH_INFO']);
  $t->set_var("siteowner", get_setting("webmaster_contact_email"));
  $t->set_var("sitename",SITENAME);
  
  $query="select * from session where session_id='$session'";
  $q->query($query);
  if ($q->nf()!=0)
  {
  	 $q->next_record();
	 if ($q->f("paid")==1) 
	 {
	 	header("Location: continue.php");
		die();
	 }
  }
  
include("inc.bottom.php");
?>