<?php
include ("inc.all.php");
$query="update settings set value='".$otobckeactive."' where name='otobckeactive'";
$q->query($query);
$query="update settings set value='".$otobckes."' where name='otobckes'";
$q->query($query);
$query="update settings set value='".$otobckeb."' where name='otobckeb'";
$q->query($query);
$query="update settings set value='".$otobckedays."' where name='otobckedays'";
$q->query($query);
$query="update settings set value='".$otobckem."' where name='otobckem'";
$q->query($query);
$query="update settings set value='".$otobckeusescript."' where name='otobckeusescript'";
$q->query($query);
header("location: otobckemail.php");
?>