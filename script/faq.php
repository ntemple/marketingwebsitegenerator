<?php 
include("inc.top.php");
	$ar_host=parse_url(get_setting("site_full_url"));
	$host=$ar_host["host"];
	$path=$ar_host["path"];
	$host=str_replace("www","",$host);
	$t->set_file("content", "faq.html");
	$q2=new CDB;
	$query="SELECT menu_category FROM menus WHERE link='faq.php'";
	$q2->query($query);
	$toall=0;
	while ($q2->next_record()) {
		if ($q2->f('menu_category')=="main") {
			$toall=1;
		}
	}
	if ($toall==0) {
		 get_logged_info();
		 $query="SELECT id FROM menus WHERE link='faq.php'";
		 $q2->query($query);
		 $q2->next_record();
		 $query="SELECT membership_id FROM menu_permissions WHERE menu_item='".$q2->f("id")."'";
		 $q2->query($query);
		 while ($q2->next_record()) {
		 	$permissions[]=$q2->f("membership_id");
		 }
		 if (count($permissions)>0) {
		 	$error='<center><font color="red"><b>You do not have access to this area!<br><br>Upgrade your membership level!</b></font></center>';
		 	foreach ($permissions as $value) {
		 		if ($value==$q->f("membership_id")) {
		 			$error='';
		 			break;
		 		}
			}
			if ($error!="") {
				die("$error");
			}
		 }	
	}
	$t->set_file("cat_t", "faq.cat.html");
	$t->set_file("question_t", "faq.question.html");
	$t->set_file("question_answer_t", "faq.question.answer.html");
	$query="select * from faq order by faq_category asc, position asc";
	$q->query($query);
	$ccat="";
	while ($q->next_record())
	{
		$t->set_var("question",stripslashes($q->f("question")));
		$t->set_var("answer",stripslashes($q->f("answer")));
		if ($ccat!=$q->f("faq_category"))
		{
			$k=1;
			$t->set_var("cat", stripslashes($q->f("faq_category")));
			$t->set_var("no", $k);
			$t->parse("questions", "cat_t",true);
			$t->parse("questions", "question_t", true);
			$t->parse("answers", "cat_t", true);
			$t->parse("answers", "question_answer_t", true);
			$ccat=$q->f("faq_category");
		}
		else
		{
			$k++;
			$t->set_var("no", $k);
			$t->parse("questions", "question_t", true);
			$t->parse("answers", "question_answer_t", true);
		}
		
	}
	
	
include("inc.bottom.php");
?>