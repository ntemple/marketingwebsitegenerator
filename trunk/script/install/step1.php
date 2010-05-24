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

  function execute_sql($filename, $autoincrementvalue)
  {
    $q=new Cdb;
    FFileRead($filename, $content);
    $a=explode(";", $content);
    $k=0;
    while ($a[$k]!="")
    {
      $query=$a[$k];
      $query=str_replace("{autoincrementstartfrom}",$autoincrementvalue, $query);
      $q->query($query);
      $k++;
    }
  }

        function FFileRead($name/*filename*/, &$contents/*returned contents of file*/)
        {
                $fd = fopen ($name, "r");
                $contents = fread ($fd, filesize ($name));
                fclose ($fd);
        }
        function FFileWrite($name, $content, $w="w+")
        {
                $filename = $name;
                $somecontent = $content;

                // Let's make sure the file exists and is writable first.
                if (is_writable($filename)) {

                   // In our example we're opening $filename in append mode.
                   // The file pointer is at the bottom of the file hence
                   // that's where $somecontent will go when we fwrite() it.
                   if (!$handle = fopen($filename, $w)) {
                                 echo "Cannot open file ($filename)";
                                 exit;
                   }

                   // Write $somecontent to our opened file.
                   if (fwrite($handle, $somecontent) === FALSE) {
                           echo "Cannot write to file ($filename) please make sure that you chmod 777 templates folder";
                           exit;
                   }


                   fclose($handle);

                } else {
                   echo "The file $filename is not writable please make sure that you chmod 777 templates folder";
                }
        }


?>
<html>
<head>
<style type="text/css">
<!--
body, td, tr {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	color: #FF0000
}
-->
</style>
</head>
<body>
<h1 align="center">Check Database Settings </h1>
<?php

if (!isset($_POST['username']) || !isset($_POST['host']) || !isset($_POST['dbname']))
{
?>
<form name="form1" method="post" action="">
<table width="550" border="0" align="center">
  <tr>
    <td>DB Username </td>
    <td><input name="username" type="text" id="username"></td>
  </tr>
  <tr>
    <td>DB Password </td>
    <td><input name="password" type="text" id="password"></td>
  </tr>
  <tr>
    <td>DB Host </td>
    <td><input name="host" type="text" id="host"></td>
  </tr>
  <tr>
    <td>DB Name </td>
    <td><input name="dbname" type="text" id="dbname" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Admin Password </td>
    <td><input name="admin_password" type="text" id="admin_password"></td>
  </tr>
  <tr>
    <td>What ID number do you want to start members at. Default is 2. You may want to start at 500 or 5000 to make your site seem established. This is optional and has no affect on your site function.</td>
    <td><input name="member_increment" type="text" id="member_increment" value=2></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
<div align="center">
<input type="submit" name="Submit" value="Check settings">
<?php

}
else
{
	$conn=@mysql_connect ( $_POST['host'], $_POST['username'] , $_POST['password'] );
	if ($conn)
	{
		$dbres=@mysql_select_db (  $_POST['dbname'] );
		if ($dbres)
		{
			FFileRead("constants.php.html", $content);
			$content=str_replace("{host}", $_POST['host'], $content);
			$content=str_replace("{db_name}", $_POST['dbname'], $content);
			$content=str_replace("{user}", $_POST['username'], $content);
			$content=str_replace("{password}", $_POST['password'], $content);
			$content=str_replace("{admin_password}", $_POST['admin_password'], $content);
			FFileWrite("../config/constants.php", $content);
			include("inc.all.php");
			if ($member_increment<2) $member_increment=2;
			execute_sql("install.sql", $member_increment);
			$query="INSERT INTO `promo_tools` ( `id` , `category` , `content` , `template` ) 
VALUES (
'', 'Pop Exit', '<SCRIPT LANGUAGE=\"JavaScript\"> var cookie=\"qspVF8JC\"; var exit=true; var filename=''{aff_link}''; var popup; var height=\"+screen.height+\"; var width=\"+screen.width+\"; var left=(screen.width/2)-(\"+screen.width+\"/2); var top=(screen.height/2)-(\"+screen.height+\"/2); function exitpop(){ if(exit){ if (getcookie(cookie)==\"\"){ popup = window.open(filename, \"\",\"height=\"+height+\",width=\"+width+\",top=\"+top+\",left=\"+left+\",location=yes,menubar=yes,resizable=yes,scrollbars=yes,status=yes,titlebar=yes,toolbar=yes,directories=yes\"); setcookie(); } } } function getcookie(cookieName) { var id = cookieName + \"=\"; var cookievalue = \"\"; if (document.cookie.length > 0) { offset = document.cookie.indexOf(id); if (offset != -1) { cookievalue = \"x\"; } } return cookievalue; } function setcookie () { var today = new Date(); var expdate = new Date(today.getTime() + 1 * 24 * 60 * 60 * 1000); document.cookie = cookie + \"=\" + escape (\"done\")+ \";expires=\" + expdate.toGMTString(); } document.onunload=exitpop; window.onunload=exitpop; </SCRIPT> ', '1')";
			$q->query($query);
			
			$query="INSERT INTO `promo_tools` ( `id` , `category` , `content` , `template` ) 
VALUES ('', 'Pop Under', ' <SCRIPT LANGUAGE=\"JavaScript\"> <!--begin /* * Popup code generated by PopUpMaster Pro from * http://popupmaster.com * Copyright (c)2003, Steve Shaw, takanomi.com */ var cookie=\"y9KEzLHv\"; var popup; var height=\"+screen.height+\"; var width=\"+screen.width+\"; var left=0; var top=0; entrypop(''{aff_link}''); function entrypop(filename){ if (getcookie(cookie)==\"\"){ popup = window.open(filename, \"\",\"height=\"+height+\",width=\"+width+\",top=\"+top+\",left=\"+left+\",location=yes,menubar=yes,resizable=yes,scrollbars=yes,status=yes,titlebar=yes,toolbar=yes,directories=yes\"); self.focus(); setcookie(); } } function getcookie(cookieName) { var id = cookieName + \"=\"; var cookievalue = \"\"; if (document.cookie.length > 0) { offset = document.cookie.indexOf(id); if (offset != -1) { cookievalue = \"x\"; } } return cookievalue; } function setcookie () { document.cookie = cookie + \"=\" + escape (\"done\"); } // end --> </SCRIPT> ', '1')";
			$q->query($query);
			?>
<center>
  Database ok , please click Next to continue <br>
  <input type="button" value="Next Step >>" onClick="javascript: window.location.href='install-frames.php';">
</center>
<?php

		}
		else
		{
			?>
<form name="form1" method="post" action="">
<table width="550" border="0" align="center">
  <tr>
    <td>DB Username </td>
    <td><input name="username" type="text" id="username" /></td>
  </tr>
  <tr>
    <td>DB Password </td>
    <td><input name="password" type="text" id="password" /></td>
  </tr>
  <tr>
    <td>DB Host </td>
    <td><input name="host" type="text" id="host" /></td>
  </tr>
  <tr>
    <td>DB Name </td>
    <td><input name="dbname" type="text" id="dbname" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Admin Password </td>
    <td><input name="admin_password" type="text" id="admin_password" /></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
<div align="center">
<center>
  <span class="style2"> Connect to db failed, please check your connection settings and retry!</span>
</center>
<input type="submit" name="Submit" value="ReCheck settings">
<?php

		}
	}
	else
	{
		?>
<form name="form1" method="post" action="">
  <table width="550" border="0" align="center">
    <tr>
      <td>DB Username </td>
      <td><input name="username" type="text" id="username" /></td>
    </tr>
    <tr>
      <td>DB Password </td>
      <td><input name="password" type="text" id="password" /></td>
    </tr>
    <tr>
      <td>DB Host </td>
      <td><input name="host" type="text" id="host" /></td>
    </tr>
    <tr>
      <td>DB Name </td>
      <td><input name="dbname" type="text" id="dbname" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Admin Password </td>
      <td><input name="admin_password" type="text" id="admin_password" /></td>
    </tr>
  </table>
  <p align="center">&nbsp;</p>
  <div align="center">
    <center>
      <span class="style2">Connect to db failed, please check your connection settings and retry!</span>
    </center>
    <input type="submit" name="Submit" value="ReCheck settings">
    <?php
	}
	
}
?>
  </div>
</form>
</body>
</html>


