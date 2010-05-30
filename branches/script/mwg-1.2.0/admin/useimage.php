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


	include ("inc.top.php");
	if ($processor==1) $up="cb_but";
	if ($processor==2) $up="2co_but";
	if ($processor==3) $up="pp_but";
	if ($processor==4) $up="auth_but";
	$query="update products set ".$up."='$img_id' where id='$id'";
	$q->query($query);
	header("location: products.buybutton.settings.php?id=".$id);
?>