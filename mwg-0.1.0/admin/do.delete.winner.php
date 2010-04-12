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
	
$winner=get_setting("make_winner");
$winner=preg_replace("/".$camp."\:\d+\,/","",$winner);
$q->query("UPDATE settings SET value='$winner' WHERE name='make_winner'");
$q->query("SELECT file from cycle where id='".$id."'");
$q->next_record();
header("location:cycler_stats.php?file=".$q->f("file")."&campa=".$camp);
?>