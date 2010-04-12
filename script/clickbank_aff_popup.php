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
$t->set_file("content", "member.area.clickbank_aff_popup.html");
$t->set_var('cb_sell_link',"http://www.clickbank.net/sell.cgi?link=".get_setting('vendor_id')."/".$item."/&seed=".$seed);
$q->query("SELECT clickbank_id FROM members WHERE id='".$_COOKIE['aff']."'");
$q->next_record();
$t->set_var('aff_cb_lnk','http://'.($q->f('clickbank_id') ? $q->f('clickbank_id')."." : '').get_setting('vendor_id').".hop.clickbank.net");
include("inc.bottom.php");
?>