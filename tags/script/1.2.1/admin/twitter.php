<?php
/**
 * @version    $Id$
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
	MWG::getInstance()->response->initEditor();
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
