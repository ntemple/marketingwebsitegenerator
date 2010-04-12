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