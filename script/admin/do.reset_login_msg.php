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
	
	$q2 = new cdb;
	
	$query="SELECT * FROM members";
	$q->query($query);
	if ($q->nf()!=0) {
		while ($q->next_record()) {
			if ($q->f('msg_viewed')) {
				$member_id=$q->f('id');
				$msg_array=explode(',',$q->f('msg_viewed'));
				for ($j=0;$j<count($msg_array)-1;$j++){
					if ($msg_array[$j]!=$id) {
						$new_msg_viewed.=$msg_array[$j].",";
					}
				}
				$q2->query("UPDATE members SET msg_viewed="."'".$new_msg_viewed."' WHERE id='".$q->f("id")."'");
			}
		}
	}
	header("Location: login_msg.php");
	
?>