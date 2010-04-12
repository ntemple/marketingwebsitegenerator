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


include("inc.all.php");
if ($_POST['activ_code']==get_setting("activation_code_email"))
	{$code=$_POST['activ_code'];
	get_logged_info();
	$query="update members set active=1 where id='".$q->f("id")."'";
	$q->query($query);
	header("location:member.area.in.php");
	}else{ header("location:activation.php?errorcode=1");	
		}
?>