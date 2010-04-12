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
if ($_POST['serverfile']=='')
{
	$uploaddir = $_SERVER['SCRIPT_FILENAME'];
	$uploaddir=str_replace("/admin/do.add.downloadprotect.php", "/download/", $uploaddir);
	$uploadfile = $uploaddir . basename($_FILES['file']['name']);
	
	
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			if ($createmanually!=1)	
			{
				if (is_file("../".$link.".php"))
				{
					die("../".$link.".php file already exists, not overwriting, please enter another filename");
				}
				FFileRead("template.dp.php", $phpfile);
				FFileWriteNew("../".$link.".php", $phpfile, "w");
			}
			else $link.=".php";
			$query="insert into downloadprotect (file, link, memberfile, membership_id, manual) values ('".$_FILES['file']['name']."', '$link', '$memberfile', '$membership_id', '$createmanually')";
			$q->query($query);
			
			
			FFileRead("template.dp.php", $phpfile);
			FFileWriteNew("../".$link.".php", $phpfile, "w");
			
			
			
		} else {
		   echo "Possible file upload attack!\n";
		}
}
else 
{
	if ($createmanually!=1)
	{
		if (is_file("../".$link.".php"))
		{
			die("../".$link.".php file already exists, not overwriting, please enter another filename");
		}
		FFileRead("template.dp.php", $phpfile);
		FFileWriteNew("../".$link.".php", $phpfile, "w");
	}
	else $link.=".php";
	$query="insert into downloadprotect (file, link, memberfile, membership_id, manual) values ('$serverfile', '$link', '$memberfile', '$membership_id', '$createmanually')";
	$q->query($query);
	
	
	
}
header("location: downloadprotect.php");
?>