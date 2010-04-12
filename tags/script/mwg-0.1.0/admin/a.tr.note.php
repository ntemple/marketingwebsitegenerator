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

 
	include("inc.top.php");
	$t->set_file("content", "a.tr.note.html");
	if($id!=''){
		$q->query("SELECT admin_note FROM a_tr WHERE id='".$id."'");
		$q->next_record();
	
		if($q->f("admin_note")!='') {
			$t->set_var("message", $q->f("admin_note"));
			$t->set_var("save_name", 'Save Note');
			
		}else{
			$t->set_var("message", "");
			$t->set_var("save_name", 'Submit');
		}
		$t->set_var("id", $id);
		$t->set_var("warning", "");
	}elseif($member_id!=''){
		$q->query("SELECT first_name,last_name FROM members WHERE id='".$member_id."'");
		$t->set_var("save_name", 'Save Note');
		$t->set_var("message", "");
		$t->set_var("id", "");
		$t->set_var("member_id", $member_id);
		$html='<input name="member_id" value="'.$member_id.'" type="hidden"><input name="start" value="'.date("Y-m-d",mktime(0,0,0,$m_start,$d_start,$y_start)).'" type="hidden"><input name="end" value="'.date("Y-m-d",mktime(0,0,0,$m_end,$d_end+1,$y_end)).'" type="hidden">';
		$t->set_var("warning", "You are about to set an admin note for transactions done for member ".$q->f("first_name")." ".$q->f("last_name")."(id:$member_id) between ".date("Y-m-d",mktime(0,0,0,$m_start,$d_start,$y_start))." and ".date("Y-m-d",mktime(0,0,0,$m_end,$d_end,$y_end))."that have been previously set as To Be Paid".$html);
	}
	
		$t->pparse("out", "content");
?>