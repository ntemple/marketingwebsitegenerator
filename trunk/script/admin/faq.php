<?php 
include("inc.top.php");
	$t->set_file("content", "admin.faq.html");
	$t->set_file("cat_t", "admin.faq.cat.html");
	$t->set_file("question_t", "admin.faq.question.html");
	$t->set_file("question_answer_t", "admin.faq.question.answer.html");
	$query="select * from faq order by faq_category asc, position asc";
	$q->query($query);
	$ccat="";
	while ($q->next_record())
	{
		$t->set_var("question",stripslashes($q->f("question")));
		$t->set_var("answer",stripslashes($q->f("answer")));
		$t->set_var("category",stripslashes($q->f("faq_category")));
		$t->set_var("position",$q->f("position"));
		$t->set_var("id",$q->f("id"));
		if ($ccat!=$q->f("faq_category"))
		{
			$k=1;
			$t->set_var("cat", $q->f("faq_category"));
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
	if ($q->nf()==0) 
	{
		$t->set_var("questions", "");
		$t->set_var("answers", "");
	}
	
	
include("inc.bottom.php");
?>