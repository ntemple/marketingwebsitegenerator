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

 
	include("inc.all.php");
	$q2=new Cdb;
	$t->set_file("content","payment.ty.html");
	$session = $_GET['s'];
	if (get_setting("free_signup")==1)
	{
		get_logged_info(); 
		$aff_id=$q->f("aff");
	}else $aff_id=$_COOKIE["aff"];
	$member_id=$q->f("id");
	$query="select membership_id, paypal_email, jv from members where id='$aff_id'";
	$q->query($query);
	$aff_membership=-1;
	if ($q->nf()!=0)
	{
	  	$q->next_record();
		$aff_membership=$q->f("membership_id");
		$aff_pp=$q->f("paypal_email");
		$aff_jv=$q->f("jv");
	}
	if ($session=="") die("We require more parameters");
	$t->set_var("siteowner", get_setting("webmaster_contact_email"));
	$t->set_var("sitename",SITENAME);
	$query="select * from session where session_id='$session'";
	$q->query($query);
	if ($q->nf()!=0)
	{
		$q->next_record();
		$product_id=$q->f("product_id");
		//CYCLE INSERT
		$cycle = base64_decode($_COOKIE['cycle']);
		$cycle_arr = explode(":",$cycle);
		$cycle_arr_first = explode("-",$cycle_arr[0]);
		$q2->query("SELECT file FROM cycle WHERE id='".$cycle_arr[count($cycle_arr)-1]."'");
		$q2->next_record();
		
		$q2->query("UPDATE cycle_stats SET used=1 WHERE id='".$cycle_arr_first[0]."'");
		//END CYCLER
		$paid=$q->f("paid");
		$paid2=$q->f("paid_step2");
		if (get_setting("splitoption")==2){
			$query="select * from levels where product_id='$product_id' and membership_id='$aff_membership' and level=1 order by id desc limit 0,1";
		}else {
			$query="select * from levels where product_id='$product_id' and membership_id='$aff_membership' and level=1 order by id asc limit 0,1";
		}
		$q->query($query);
		if ($q->nf()==0)
		{
			$step2_flag=false;
		}
		else
		{
			$q->next_record();
			if (($q->f("paytype")=="percent_split" || $q->f("paytype")=="full_amount_split") )
			{
				if (get_setting("splitoption")==2){
					$query="select * from levels where product_id='$product_id' and membership_id='$aff_membership' and level=1 order by id asc limit 0,1";
				}else {
					$query="select * from levels where product_id='$product_id' and membership_id='$aff_membership' and level=1 order by id desc limit 0,1";
				}
				$q->query($query);
				$q->next_record();
				$step2_flag=true;
				
				if ($paid==1 && $paid2==0 && $aff_pp!='' && $step2!=1)
				{
					if (($aff_jv==2 && $q->f("jv2")==0) || ($aff_jv==1 && $q->f("jv1")==0) || ($aff_jv==0 && $q->f("value")==0) || ($aff_jv==0 && $q->f("value")==100 && $q->f("paytype")=="percent_split"))
					{ 
						$query="select signup from products where id='".$product_id."'";
						$q2->query($query);
						$q2->next_record();
						$atsignup=$q2->f("signup");
						if (get_setting("free_signup")!=1 && $atsignup!=0)
						{
							if (get_setting("enable_oto_paid_signup") == 1 && get_setting("enable_oto_1")){
								header("Location: oto.php");
							}else{
								$t->set_file("content","signup.p.html");
								
								$t->set_file("signuplist", "signup.row.html");
								$t->set_file("signuplist_b", "signup.row.html");
								$t->set_file("confirmpass", "confirm.pass.html");
								
								include("signup.kit.php");
								$t->set_var("session_id", $session);
								$t->pparse("out", "content");
								die();						
							}
						}else{
						$query="select nid from products where id='".$q->f("product_id")."'";
						$q2->query($query);
						$q2->next_record();
						if ($q2->f("nid")=='OTO1' && get_setting("enable_oto_2")==1){ header("Location: continue.php");}
						else{
							$_SESSION['oto_bck'] = 1;
						
							header("Location: continue.php");                                        
						}
						die();
					}
				}else{
					if ($q->f("value")==0) 
					{
						$query="select nid from products where id='".$q->f("product_id")."'";
						$q2->query($query);
						$q2->next_record();
						if ($q2->f("nid")=='OTO1' && get_setting("enable_oto_2")==1){ header("Location: continue.php");}
						else{
							$_SESSION['oto_bck'] = 1;
						
							header("Location: continue.php");                                        
						}
						die();
					}
				}
				$t->set_file("content", "step2.html");
				$query="select * from products where id='$product_id'";
				$q->query($query);
				$q->next_record();
				$buttons=get_pay_buttons($member_id, $product_id, $aff_id, $session, 1, 5);
				$t->set_var("product_name", $q->f("display_name"));
				$t->set_var("pay_buttons", $buttons);
				$t->pparse("out", "content");
				die();
			}
			if ($paid==1 && $paid2==1 || ($paid==1 && $aff_pp=='')) 
			{
				$query="select signup from products where id='".$product_id."'";
				$q2->query($query);
				$q2->next_record();
				$atsignup=$q2->f("signup");
				if (get_setting("free_signup")!=1 && $atsignup!=0)
				{
					if (get_setting("enable_oto_paid_signup") == 1 && get_setting("enable_oto_1")==1)
					{
						header("Location: oto.php");
					}else{
						$t->set_file("content","signup.p.html");
						
						$t->set_file("signuplist", "signup.row.html");
						$t->set_file("signuplist_b", "signup.row.html");
						$t->set_file("confirmpass", "confirm.pass.html");
						include("signup.kit.php");
								$t->set_var("session_id", $session);
								$t->pparse("out", "content");
								die();						
							}
					}else{
					$query="select nid from products where id='".$q->f("product_id")."'";
					$q2->query($query);
					$q2->next_record();
					if ($q2->f("nid")=='OTO1' && get_setting("enable_oto_2")==1){ header("Location: continue.php");}
					else{
						$_SESSION['oto_bck'] = 1;
							if ($q2->f("nid")!='OTO1' && $q2->f("nid")!='OTO_BCK' && get_setting("enable_oto_2")==1) {header("Location: continue.php");die();}
						header("Location: continue.php");                                        
					}
					die();
				}
			}
		}else{
			if (($paid==1 && $step2_flag==0) || $paid2==1)
			{
				$query="select signup from products where id='".$product_id."'";
				$q2->query($query);
				$q2->next_record();
				$atsignup=$q2->f("signup");
				if (get_setting("free_signup")!=1 && $atsignup!=0)
				{
					if (get_setting("enable_oto_paid_signup") == 1 && get_setting("enable_oto_1")){
						header("Location: oto.php");
					}else{
						$t->set_file("content","signup.p.html");
					
						$t->set_file("signuplist", "signup.row.html");
						$t->set_file("signuplist_b", "signup.row.html");
						$t->set_file("confirmpass", "confirm.pass.html");
						
						include("signup.kit.php");
								$t->set_var("session_id", $session);
								$t->pparse("out", "content");
								die();						
					}
				}else{
					$query="select nid from products where id='".$q->f("product_id")."'";
					$q2->query($query);
					$q2->next_record();
					if ($q2->f("nid")=='OTO1' && get_setting("enable_oto_2")==1) header("Location: continue.php");
		            else{
		            	$_SESSION['oto_bck'] = 1;
						if ($q2->f("nid")!='OTO1' && $q2->f("nid")!='OTO_BCK' && get_setting("enable_oto_2")==1) {header("Location: continue.php");die();}
		            	header("Location: continue.php?no=1"); 
		            }
					die();
				}
			}
		}
	}
		if (($paid==1 && $step2_flag==0) || $paid2==1)
		{
			$query="select signup from products where id='".$product_id."'";
			$q2->query($query);
			$q2->next_record();
			$atsignup=$q2->f("signup");
			if (get_setting("free_signup")!=1 && $atsignup!=0)
			{
				if (get_setting("enable_oto_paid_signup") == 1 && get_setting("enable_oto_1")){
					header("Location: oto.php");
				}else{
					$t->set_file("content","signup.p.html");
		
					$t->set_file("signuplist", "signup.row.html");
					$t->set_file("signuplist_b", "signup.row.html");
					$t->set_file("confirmpass", "confirm.pass.html");
					
					include("signup.kit.php");
								$t->set_var("session_id", $session);
								$t->pparse("out", "content");
								die();				
							}
			}else{
				$query="select nid from products where id='".$q->f("product_id")."'";
				$q2->query($query);
				$q2->next_record();
				if ($q2->f("nid")=='OTO1' || $q2->f("nid")=='OTO_BCK' && get_setting("enable_oto_2")==1) header("Location: continue.php");
		       	else{
		
					if ($q2->f("nid")!='OTO2_BCK') $_SESSION['oto2_bck'] = 1;
		       		$_SESSION['oto_bck'] = 1; 
		       		header("Location: continue.php?no=1");
		       	}
       			die();
			}
		}
	}else
	die("there is no session");
	$t->pparse("out", "content");
?>