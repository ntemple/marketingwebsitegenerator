<?php
include("inc.all.php");
if ($_SERVER['HTTP_REFERER'] == get_setting("site_full_url")."contact.php"){
	$t->set_file("content", "do.contact.html");
	@mail(get_setting("webmaster_contact_email"), $subject, $message, "From: Contact Form - $name<$email>");
}
include("inc.bottom.php");
?>