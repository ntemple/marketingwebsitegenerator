<?php 
	include("inc.top.php");
	
	$t->set_file("content", "admin.twitter.html");
	$t->set_file("row_file", "admin.twitter.row.html");
if($err==1)
	$err_msg="You are allowed 50 Tweets";
elseif($err==2)
	$err_msg="Only 170 characters are allowed";
if($save=='ok')
	$err_msg="Tweet successfully saved";			
	$query="SELECT * FROM settings WHERE name='twitter_html'";
	$q->query($query);
	$q->next_record();
	$t->set_var("twitter_html",$q->f("value"));
	$query="select * from twitter order by id asc";
	$q->query($query);
	$t->set_var("k", $k);
	if($q->nf()){
		while ($q->next_record())
		{
			$t->set_var("id", $q->f("id"));
			$t->set_var("tweet", stripslashes($q->f("tweet")));
			$t->parse("twitter_rows", "row_file", true);
		}	
	}else $t->set_var("twitter_rows","");
	include('inc.bottom.php');
if($err_msg!='')
	echo "<script>alert('".$err_msg."')</script>";
?>