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
	$q=new Cdb;
	$q2=new CDb();
	$query="update members set membership_id='$moveto' where membership_id='$id'";
	$q->query($query);
	
	$query="SELECT * FROM members";
	$q2->query($query);
	while ($q2->next_record()) {
		if ($q2->f("membership_id")==$id) {
			updateHistory($q2->f("id"), $moveto, true);
			updateHistory($member_h_id, $id);
		}
	}
	
	
	$query="delete from membership where id='$id'";
	$q->query($query);
	header("location:membership.php");
?>