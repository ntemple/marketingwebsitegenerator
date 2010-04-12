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


	include "inc.top.php";
	
	$query="select * from buybuttons where product_id='$id'";
	$q->query($query);
	if ($q->nf()==0) $t->set_var("content", "No Images Found");
	else
	{
		while ($q->next_record())
		{
			
			if ($q->f("url")==1)
			{
				$path=$q->f("image");
								
			}
			else $path="../images/buybuttons/".$q->f("image");
			
			$info=getimagesize($path);
			
			if ($info[0]>160)
			{
				$ratio=max(intval($info[0]/$info[1]), 1);
				$newwidth=160;
				$newheight=120;
				$image.="<img src=$path width=$newwidth height=$newheight onClick=\"parent.document.getElementById('img_id').value='".$q->f("id")."'; parent.document.getElementById('img_id2').value='".$q->f("id")."'; parent.document.getElementById('swapimage').src='$path'; parent.document.getElementById('hiddenform').style.display=''; parent.document.getElementById('firstform').style.display='none'\" style=\"cursor: pointer\">";
			}
			else $image.="<img src=$path onClick=\"parent.document.getElementById('img_id').value='".$q->f("id")."'; parent.document.getElementById('img_id2').value='".$q->f("id")."'; parent.document.getElementById('swapimage').src='$path'; parent.document.getElementById('hiddenform').style.display=''; parent.document.getElementById('firstform').style.display='none'\" style=\"cursor: pointer\">";
			
		}
		$t->set_var("content", $image);
	}
	
	$t->set_file("main", "admin.main.empty.html");
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main"); 
	
?>