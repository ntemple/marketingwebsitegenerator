<?php
include("inc.all.php");
$t->set_var("email", $_COOKIE["emailx"]);
$t->set_file("content", "login.html");
include("inc.bottom.php");
?>