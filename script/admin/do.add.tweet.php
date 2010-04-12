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
$q->query("SELECT * FROM twitter");
$err="";
if($q->nf()<50 ){
	if(strlen($tweet)<=140)
		$q->query("INSERT INTO twitter SET tweet='".addslashes($tweet)."'");
	else $err="?err=2";
}else $err="?err=1";
header("location:twitter.php".$err);	
?>