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
	
	$t->set_file("content", "admin.promo.tools.html");
	$t->set_file("row_file", "admin.promo.tools.row.html");
	$t->set_file("cat_file", "admin.promo.tools.category.html");
	$t->set_file("templates_file", "admin.promo.tools.templates.html");
	
	$query="select * from promo_tools where template=1 order by category";
	$q->query($query);
	while ($q->next_record())
	{
		$t->set_var("id", $q->f("id"));
		$t->set_var("category", $q->f("category"));
		$t->parse("templates", "templates_file", true);
	}
	
	if ($template=="")
	{
		$t->set_var("category_template", " ");
		$t->set_var("content_template", " ");
		
	}
	else
	{
		$query="select * from promo_tools where id='$template' and template=1";
		$q->query($query);
		if ($q->nf()==0)
		{
			$t->set_var("category_template", " ");
			$t->set_var("content_template", " ");
		}
		else
		{
			$q->next_record();
			$t->set_var("category_template", $q->f("category"));
			$t->set_var("content_template", encodeHTML(stripslashes($q->f("content"))));
		}
	}
	$query="select * from promo_tools where template<>1 order by rank ASC ";
	$q->query($query);
	$k=1;
	if ($q->nf()!=0) 
	{
		$q->next_record();
		$category=$q->f("category");
		$t->set_var("contentx", encodeHTML(stripslashes($q->f("content"))));
		$t->set_var("category", $q->f("category"));
		$t->set_var("id", $q->f("id"));
		$t->parse("promo_tools", "cat_file", true);
		$t->set_var("k", $k);
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.promo.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=down')\"/>  Move up/down use this arrow to arrange the display order to your preference";
		
		$t->set_var("link_move", $link_move);
		$t->parse("promo_tools", "row_file", true);
		
	}
	$i = 0;
	$nr_fields = $q->num_rows();
	while ($q->next_record())
	{
		$i++;
		$k++;
		$t->set_var("category", $q->f("category"));
		if ($category!=$q->f("category"))
		{
			$t->parse("promo_tools", "cat_file", true);
		}
		$t->set_var("contentx",encodeHTML(stripslashes($q->f("content"))));
		$t->set_var("category", $q->f("category"));
		$t->set_var("k", $k);
		$t->set_var("id", $q->f("id"));
		if ($i == $nr_fields-1){
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.promo.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=up')\"/>  Move up/down use this arrow to arrange the display order to your preference";
		}else{
			$link_move = "<img style='cursor:pointer' style='border:none;' src='../images/arrow_down.jpg' title='Down' onclick=\"makeRequest('do.move.promo.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=down')\"/>&nbsp;<img style='cursor:pointer' style='border:none;' src='../images/arrow_up.jpg' title='Up' onclick=\"makeRequest('do.move.promo.php?id=".$q->f("id")."&rank=".$q->f("rank")."&move=up')\"/>  Move up/down use this arrow to arrange the display order to your preference";
		}
		
		$t->set_var("link_move", $link_move);
			$t->parse("promo_tools", "row_file", true);
	}
	GetTags($tags);
	if (strlen($tags)==0) $t->set_var("tag_list", "{affiliate_id}");
	else
	{
		$t->set_var("tag_list", $tags);
	}
	include('inc.bottom.php');
?>