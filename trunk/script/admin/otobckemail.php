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
$t->set_file("content", "admin.otoemail.html");
$q2 = new CDb();
$query="select name, value from settings where name='otobckeactive' or name='otobckes' or name='otobckeb' or name='otobckem' or name='otobckedays' or name='otobckeusescript'";
$q->query($query);	
while ($q->next_record())
{
	$t->set_var($q->f("name"), $q->f("value"));
	if( $q->f("name")!="otobckeb" && $q->f("name")!="otobckes"  ) $t->set_var($q->f("name").$q->f("value"), "checked");
	
}
$t->set_var("link", get_setting("site_full_url")."login.oto.php");
GetTags($tags);
$t->set_var("taglist", $tags);
include("inc.bottom.php");
?>