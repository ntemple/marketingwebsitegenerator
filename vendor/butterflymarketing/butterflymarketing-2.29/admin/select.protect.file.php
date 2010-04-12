<?php 
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