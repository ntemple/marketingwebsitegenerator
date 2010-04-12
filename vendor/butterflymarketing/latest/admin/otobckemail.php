<?php
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