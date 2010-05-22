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

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

if (count($_POST)) {
  include("inc.top.php");
  FFileWrite($filename, html_entity_decode(stripslashes($contentb)));
  header("location: editor.php?menu=design&id=" . $_POST['id']);
  exit();     
}

include("inc.top.php");
$t->set_file("content", "admin.editor.html");
$t->set_file("template_row", "admin.editor.row.html");

$mwg = MWG::getInstance();

$files = $mwg->listFiles('../templates');
sort($files);

foreach ($files as $file) {
  $t->set_var('id', $file);
  $t->set_var('name', $file);
  $t->parse('templates', "template_row", true);
}

if (isset($_GET['id'])) {
  $t->set_var('id', $_GET['id']);
  $filename = $_GET['id']; // @todo sanitize
  $t->set_var("filename","../templates/$filename");
  $file_c = '';
  if (filesize("../templates/$filename")!=0) {
    FFileRead("../templates/$filename", $file_c);
  }
  // $file_c implicit??
  $t->parse("content_template", "content_template_f", true);
} else {
  $t->set_var("name", "NONE");
  $t->set_var("description","");
  $t->set_var("filename","");
  $t->set_var("content_template", "");
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
		$t->set_file("main", "admin.main.html");
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
