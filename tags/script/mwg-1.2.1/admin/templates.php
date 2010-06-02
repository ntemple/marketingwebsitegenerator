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

 /**
 * This doesn't use the standard inc.bottom.php for some reason
 * prime canidtate for refactoring
 * @tdodo refactor templates.php
 * @todo TEST: Site Design | Site Templates
 */
 
	include("inc.top.php");
	$t->set_file("content", "admin.templates.html");
	$t->set_file("template_row", "admin.templates.row.html");
	
	GetPayButtonsList($t);
	$query="select * from templates where filename='main.html' or filename='main.vertical.html' or filename='oto1.html' or filename='oto2.html' or filename='main.nologin.html' or filename='main.vertical.nologin.html' order by name desc";
	$q->query($query);
	
	while ($q->next_record())
	{
		$t->set_var("id", $q->f("id"));
		$t->set_var("name", $q->f("name"));
		$t->parse("templates", "template_row", true);
		
	}
	$query="select * from templates where filename!='main.html' and filename!='main.vertical.html' and filename!='oto1.html' and filename!='oto2.html' and filename like '%.sl.%' order by name desc";
	$q->query($query);
	
	while ($q->next_record())
	{
		$t->set_var("id", $q->f("id"));
		$t->set_var("name", $q->f("name"));
		$t->parse("templates1", "template_row", true);
		
	}
	$query="select * from templates where filename!='main.html' and filename!='main.vertical.html' and filename!='oto1.html' and filename!='oto2.html' and filename like '%.dw.%' order by name desc";
	$q->query($query);
	
	while ($q->next_record())
	{
		$t->set_var("id", $q->f("id"));
		$t->set_var("name", $q->f("name"));
		$t->parse("templates2", "template_row", true);
		
	}
	$query="select * from templates where filename!='main.html' and filename!='main.vertical.html' and filename!='oto1.html' and filename!='oto2.html' and filename like '%.ag.%' and filename not like '%.sl.%' and filename not like '%.dw.%' order by name desc";
	$q->query($query);
	
	while ($q->next_record())
	{
		$t->set_var("id", $q->f("id"));
		$t->set_var("name", $q->f("name"));
		$t->parse("templates3", "template_row", true);
		
	}
	$query="select * from templates where filename!='main.html' and filename!='main.vertical.html' and filename!='oto1.html' and filename!='oto2.html' and filename not like '%.sl.%' and filename not like '%.dw.%' and filename not like '%.ag.%' order by name desc";
	$q->query($query);
	
	while ($q->next_record())
	{
		$t->set_var("id", $q->f("id"));
		$t->set_var("name", $q->f("name"));
		$t->parse("templates4", "template_row", true);
		
	}
	if ($id=="")
	{
		$t->set_var("name", "NONE");
		$t->set_var("description","");
		$t->set_var("filename","");
		$t->set_var("content_template", "");
		
	}
	else
	{
		$query="select * from templates where id='$id'";
		$q->query($query);
		$q->next_record();
		
		$t->set_var("name", $q->f("name"));
		$t->set_var("description",$q->f("description"));
		$t->set_var("filename","../templates/".$q->f("filename"));
		if (filesize("../templates/".$q->f("filename"))!=0)
		FFileRead("../templates/".$q->f("filename"), $file_c);
		else $file_c='';
		//$t->set_var("content_template_f", stripslashes($file_c));
		$t->parse("content_template", "content_template_f", true);
	}
	if ($notemplate)
	{
		$back="<input type=\"button\" onClick=\"parent.mainFrame.location='".$from.".php?from=".$from."'\" value=\"Back\">";
		$t->set_var("back", $back);
	}
	else
	$t->set_var("back", "");


  ///////////////////////////
  include("skin.php");
	$final=$t->pparse2("out", "main");
	
	if ($notemplate)
	{
		$t->set_var("sitename", SITENAME);
		$ocontent=$t->parse("page", "content");
		$t->set_var("content", $ocontent);
		$final=$t->pparse2("out", "content");
		if ($from) 
		{
			$final=str_replace("{from}", "?from=".$from, $final);
			$_SESSION["from"] = $from;
		}
		$final='<script language=JavaScript src="../editor/scripts/innovaeditor.js"></script>
					<link href="../css/butterfly.css" rel="stylesheet" type="text/css">'.$final;
		
		$_SESSION["notemplate"] = $notemplate;
	}
	else
	{
		$query="select id from messages where member_id=1 and read_flag=0";
		$q->query($query);
		$q->next_record();
		$t->set_var("newmessages", $q->nf());
#		$t->set_file("main", "admin.main.html");
		$t->set_var("sitename", SITENAME);
		$ocontent=$t->parse("page", "content");
		$t->set_var("content", $ocontent);
		$final=$t->pparse2("out", "main");
	}	
	GetTags($tags);
	$final=str_replace("{tag_list}", $tags, $final);
	FFileRead("../config/version", $version);
	$final=str_replace("{version}", $version, $final);
	$final=str_replace("[[content_template]]", htmlspecialchars(stripslashes($file_c)), $final);
  
  genstall_admin_end($t, $final, $notemplate);  

