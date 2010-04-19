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
$q2 = new CDb();
	$t->set_file("content", "admin.shipping_table.html");
	$t->set_file("ship_row", "admin.shipping_table.row.html");
	
	$q2->query("SELECT fee FROM products WHERE id='$id'");
	$q2->next_record();
	
	$fees_arr = array();
	$fees1_arr = explode('|',$q2->f('fee'));
	foreach ($fees1_arr as $key=>$value){
		$pos = strpos($value,';');
		$fee = substr($value,0,$pos);
		$country_id = substr($value,$pos+1);
		$fees_arr [$country_id] = $fee;	
	}
		
	$query="select * from countries order by country asc";
	$q->query($query);
	$i = 0;
	while ($q->next_record()) {
		$i++;
		if ($i % 2 == 1)
			$t->set_var("bg_color",'#877777');
		else 
			$t->set_var("bg_color",'#CCCCCC');
		$t->set_var("country",$q->f("country"));
		$t->set_var("cid",$q->f("id"));
		$t->set_var("fee_".$q->f("id"),$fees_arr[$q->f("id")]);
		if ($fees_arr[$q->f("id")]!="") $t->set_var("chk_cid", 'checked'); else $t->set_var("chk_cid", '');
		$t->parse("shipping_table","ship_row",true);
	}
	$t->set_var("id",$id);
	
	$t->set_file("main", "admin.main.empty.html");
	$ocontent=$t->parse("page", "content");
	$t->set_var("content", $ocontent);
	$t->pparse("out", "main");
?>