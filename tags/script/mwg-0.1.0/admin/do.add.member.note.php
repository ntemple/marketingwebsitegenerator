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
	$q->query("INSERT INTO member_notes SET message='".$_POST['notes']."', member_id='".$_GET['member_id']."', writer='".$_POST['admin']."', date=NOW()");
	
	
?>
<script>
window.self.close();window.opener.location.reload();
</script>