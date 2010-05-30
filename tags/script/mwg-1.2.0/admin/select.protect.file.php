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

 
include ("inc.top.php");
$t->set_file("content", "admin.select.protected.files.html");
if ($handle = opendir('../download')) {
$i=1;
   while (false !== ($file = readdir($handle))) {
   if ($i>0 && $file!="." && $file!=".." && $file!=".htaccess") {
		$filelist.='<tr><td><a href="#" onClick="window.opener.document.form1.serverfile.value=\''.$file.'\';self.close();">'.$file.'</a></td><td>'.number_format(filesize('../download/'.$file)/1024,2) .'KB</td></tr>';
   }
	$i++;
   }
   closedir($handle);
}
$t->set_var("file_list", $filelist);
$t->set_file("main", "admin.main.empty.html");
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main");
?>