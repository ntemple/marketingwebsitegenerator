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


############################################################
##                        WARNING!                        ##
##                                                        ##
## This script is copyrighted to ButterFlyMarketing.com   ##
## Duplication, selling, or transferring of this script   ##
## is a violation of the copyright and purchase agreement.##
## Alteration of this script in any way voids any         ##
## responsibility ButterFlyMarketing.com has towards the  ##
## functioning of the script. Altering the script in an   ##
## attempt to unlock other functions of the program that  ##
## have not been purchased is a violation of the purchase ##
## agreement and forbidden by ButterFlyMarketing.com.     ##
## By modifying/running this script you agree to the terms##
## and conditions of ButterFlyMarketing.com located at    ##
## http://www.butterflymarketing.com/terms.php            ##
############################################################
require_once("../lib/inc.db_mysql.php");
require_once("../lib/inc.template.php");
//define database object 
class CDb extends DB_Sql
{
		var $classname = "CDb";
		var $Host=DB_HOST;
		var $Database=DB_NAME;
		var $User=DB_USER;
		var $Password=DB_PASSWORD;
		function haltmsg($msg)
		{
			$t = new Template("../templates", "keep");
			$t->set_file("error", "error.html");
			if (DEBUG_TYPE=="browser" || DEBUG_TYPE=="be")
			{
				$t->set_var("sitename", SITENAME);
				$t->set_var("details", "Database error: $msg<br><b>MySQL Error</b>:".$this->Errno." ".$this->Error);
			}
			else
			if (DEBUG_TYPE=="email" || DEBUG_TYPE=="be")
			{
				@mail(EM_SEND_DB_ERR, SITENAME." Mysql Error", "Database error: $msg<br><b>MySQL Error</b>:".$this->Errno." ".$this->Error, "From: ".SITENAME."<noreply@noreply.com>");
				$t->set_var("sitename", SITENAME);
				
			}
			$t->pparse("out", "error");
			die();
		}
	}
	
	
	$t = new Template("../templates", "remove");
require_once("../lib/inc.general.functions.php");
require_once("../config/constants.php");
	$q = new Cdb;
?>