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
	get_logged_info(); //member area init...
	$u_sess_id=$q->f("id");
	switch ($action)
	{
		case "pending": $status=1; break;
		case "current": $status=0; break;
		case "past": $status=2; break;
		case "cancelled": $status=3; break;
	}
	$cmember="";
	FFileRead("templates/a.template.aff.tr.htm",$cmember);
	
	FFileRead("templates/a.template.aff.tr.row.htm",$row);
	$query="select * from a_tr where member_id='$u_sess_id' and status='$status' order by id";
	$q->query($query);
	if ($q->nf()==0)
		$rows="<tr><td colspan=3>NO TRANSACTIONS FOUND</td></tr>";
	else
	while ($q->next_record())
	{
		switch ($q->f("status"))
		{
			case 1: $st="Pending"; break;
			case 0: $st="Active"; break;
			case 2: $st="Past"; break;
			case 3: $st="Cancelled"; break;
		}
		$rows.=str_replace("{id}",$q->f("id"),$row);
		$rows=str_replace("{amount}",$q->f("amount"),$rows);
		$rows=str_replace("{currency}",get_setting('paypal_currency'),$rows);
		$rows=str_replace("{status}",$st,$rows);
		$rows=str_replace("{dt}",$q->f("dt"),$rows);
		$rows=str_replace("{comments}",$q->f("comments"),$rows);
	}
	
	$query="select sum(amount) as n from a_tr where status='$status' and member_id='$u_sess_id'";
	$q->query($query);
	$q->next_record();
	$cmember=str_replace("{total}",$q->f("n"),$cmember);
	$cmember=str_replace("{id}",$u_sess_id,$cmember);
	$cmember=str_replace("{rows}",$rows,$cmember);
	$cmember=str_replace("{currency}",get_setting('paypal_currency'),$cmember);
	$cmember=str_replace("{action}",$action,$cmember);
	$cmember=str_replace("{sitename}",$sitename,$cmember);
	$content=$cmember;
	echo $content; 
?>