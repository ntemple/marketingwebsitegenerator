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
	
	$q->query("SELECT * FROM countries order by country asc");
	$for_query = '';
	while ($q->next_record()){
		if ($_POST['country_'.$q->f('id')]){
			$for_query .= $_POST['fee_'.$q->f('id')].";".$q->f('id')."|";
		}
	}
	$for_query = substr($for_query,0,-1);
	$query="update products set fee='$for_query' where id='".$_POST['id']."'";
	$q->query($query);
		
echo "<script>window.self.close();</script>";
	
?>