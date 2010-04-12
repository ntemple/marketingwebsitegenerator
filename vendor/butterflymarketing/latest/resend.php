<?php
include ("inc.all.php");
$t->set_file("content", "activation.html");
if (get_setting("activation_email")==1)
{
	get_logged_info();
	$member_id = $q->f("id");
	$email=$q->f("email");
	$emailsubject=get_setting("activation_email_subject");
	$emailsubject=str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$q->f("code"), $emailsubject);
	$emailbody=get_setting("activation_email_body");
	$emailbody=str_replace("{activation_link}", get_setting("site_full_url")."activate.php?code=".$q->f("code"), $emailbody);
	@mail($email, email_replace2($emailsubject,$member_id), email_replace2($emailbody), "From: ".get_setting("emailing_from_name")." <".get_setting("emailing_from_email").">");
}
include ("inc.bottom.php");
?>