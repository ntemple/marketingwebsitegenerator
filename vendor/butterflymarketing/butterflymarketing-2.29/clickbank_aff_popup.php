<?php 
include("inc.all.php");
$t->set_file("content", "member.area.clickbank_aff_popup.html");
$t->set_var('cb_sell_link',"http://www.clickbank.net/sell.cgi?link=".get_setting('vendor_id')."/".$item."/&seed=".$seed);
$q->query("SELECT clickbank_id FROM members WHERE id='".$_COOKIE['aff']."'");
$q->next_record();
$t->set_var('aff_cb_lnk','http://'.($q->f('clickbank_id') ? $q->f('clickbank_id')."." : '').get_setting('vendor_id').".hop.clickbank.net");
include("inc.bottom.php");
?>