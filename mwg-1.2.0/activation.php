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


include ("inc.all.php");
$t->set_file("content", "activation.html");
if ($_GET['errorcode']==1) {
								$t->set_var("activation","<p align='center'>You entered wrong activation code.</p>
													<p align='center'>Please insert the correct activation code :</p>
													<form action='do.activation.php' method='post'><p align='center'><input type='text' name='activ_code' id='activ_code' size='40'</p>
													<p align='center'><input type='submit' value='Activate'></form></p>");
							}
else {	if(get_setting("activation_email_type")==1) {
												$t->set_var("activation","<p align='center'>Your account has not yet been activated. Please check your mail 
												inbox for a confirmation link.</p>
												<p align='center'>Or <a href='resend.php'>click here</a> to resend the 
												confirmation email to activate your account.</p>");
												}
			else if(get_setting("activation_email_type")==2){ 
														$t->set_var("activation","<p align='center'>Your account is not activated.</p>
														<p align='center'>Please insert the activation code :</p>
														<form action='do.activation.php' method='post'><p align='center'><input type='text' name='activ_code' id='activ_code' size='40'</p>
														<p align='center'><input type='submit' value='Activate'></form></p>");
													}
	}	
include ("inc.bottom.php");
?>