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


include ("inc.top.php");
if ($img=='')
{
	$uploaddir = $_SERVER['SCRIPT_FILENAME'];
	$uploaddir=str_replace("/admin/do.upload.php", "/images/buybuttons/", $uploaddir);
	$uploadfile = $uploaddir . basename($_FILES['file']['name']);
	if ($_FILES['file']['type']=="image/gif" || $_FILES['file']['type']=="image/jpeg" || $_FILES['file']['type']=="image/png" || $_FILES['file']['type']=="image/pjpeg") {
	
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			include ("inc.top.php");
			$query="insert into buybuttons (product_id, image, url, processor) values ('$id', '".$_FILES['file']['name']."', '0', '$processor')";
			$q->query($query);
			
			
			
			
		} else {
		   echo "Possible file upload attack!";die();
		}
	}
	else {echo "Only Images are allowed for upload.<a href='products.buybutton.settings.php?id=".$id."'>Go Back</a>";
	die();
	}
}
else 
{
	$query="insert into buybuttons (product_id, image, url, processor) values ('$id', '$img', '1', '$processor')";
	$q->query($query);
}
header("location: products.buybutton.settings.php?id=".$id);
?>