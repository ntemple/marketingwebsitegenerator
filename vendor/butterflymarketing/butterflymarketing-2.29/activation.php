<?php
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