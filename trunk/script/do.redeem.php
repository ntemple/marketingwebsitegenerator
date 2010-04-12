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

 
include("inc.all.php");
	get_logged_info(); //member area init...
	$id=$q->f("id");
	$query="select * from membership where promo_code='$promo'";
	$q->query($query);
	if ($q->nf()!=0 && $promo!="NONE" && trim($promo)!="")
	{
		$q->next_record();
		$query="update members set membership_id='".$q->f("id")."' where id='$id'";
		$q->query($query);
		updateHistory($id, $q->f("id"), true);
		
	}
	header("Location: member.area.membership.ag.php");
?>