<?php
/**
 * @version    $Id: $
 * @package    MWG
 * @copyright  Copyright (C) 2010 Intellispire, LLC. All rights reserved.
 * @license    GNU/GPL v2.0, see LICENSE.txt
 *
 * Marketing Website Generator is free software. 
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

 
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