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
$_SESSION['oto_bck']=0;
$q3=new cdb;
$q2=new cdb;
if (get_setting("enable_oto_paid_signup") != 1 || get_setting('free_signup') == 1){
	$seen=$q->f("seen");
}
$query="SELECT * FROM session WHERE secret_pay_id='".md5(get_setting('secret_string').getenv('REMOTE_ADDR'))."' and paid=1 order by id desc limit 1";
$q->query($query);
$q->next_record();
if (get_setting("enable_oto_paid_signup") == 1 && get_setting("free_signup")!=1 && !get_setting('use_aim')){
	if ($q->f("affiliate_id")!=0)
	{
		$query="select membership_id from members where id='".$q->f("affiliate_id")."'";
		$q2->query($query);
		$q2->next_record();
		$aff_m_id=$q2->f("membership_id");
		$query="select * from levels where product_id='".$q->f("product_id")."' and level='1' and membership_id='$aff_m_id' and value!=0";
		$q2->query($query);
		if ($q2->nf()==0 || $q2->nf()==1)
		{
			$spaid1=1;
			$spaid2=0;
		}
		else
		{
			$spaid1=1;
			$spaid2=1;
		}
	}
	else {
		$spaid1=1;
		$spaid2=0;
	}
	if (get_setting("enable_oto_1")==1 && $q->f("paid")==$spaid1 && $q->f("paid_step2")==$spaid2 && $_SESSION['second']<2)
	{
	
		$t->set_file("content", "oto1.html");
			
		$t->set_var("text_for_popup", get_setting("text_for_popup"));
		$t->set_var("text_no_buy", get_setting("text_no_buy"));
		$query="select * from products where nid='OTO1'";
		$q->query($query);
		$q->next_record();
		$product_id=$q->f("id");
		$aff_id=$_COOKIE["aff"];
		$session=new_sess_id();
		$step2=0;
		//START CYCLER CODE
		if (get_setting('activate_cycler')){
			if ($_COOKIE['cycle']=='')
			{
				$query="select * from cycle WHERE file='oto.php' group by cycle";
				$q->query($query);
				$i=0;
				while ($q->next_record())
				{
					$winner=get_setting("make_winner");
						
					if ( preg_match('/('.$q->f("cycle").')\:(\d+)/',$winner,$match)){
						$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
						$q2->next_record();
						$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
					}
					else{
						$query="select * from cycle where file='oto.php' AND cycle='".$q->f("cycle")."' order by rand() limit 1";
						$q2->query($query);
						$q2->next_record();
						if ($i==0)
						{
							$cookiecycle=$q2->f("cycle").":".$q2->f("id");
							$i=1;
						}
						else
						$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
						$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
					}
				}
				$ar_host=parse_url(get_setting("site_full_url"));
				$host=$ar_host["host"];
				$path=$ar_host["path"];
				$host=str_replace("www","",$host);
				if ($q->nf() != 0)
				$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto'");
				setcookie("cycle",base64_encode($cookiecycle),time()+7200, $path, $host);
			}
			else
			{
				$text=base64_decode($_COOKIE['cycle']);
				$cycle=explode(":", $text);
				$query="select text,file from cycle where id='".$cycle[1]."'";
				$q->query($query);
				$q->next_record();
				if ($q->f('file') != 'oto.php'){
					$query="select * from cycle WHERE file='oto.php' group by cycle";
					$q->query($query);
					$i=0;
					while ($q->next_record())
					{
						$winner=get_setting("make_winner");
							
						if ( preg_match('/('.$q->f("cycle").')\:(\d+)/',$winner,$match)){
							$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
							$q2->next_record();
							$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
						}
						else{
							$query="select * from cycle where file='oto.php' AND cycle='".$q->f("cycle")."' order by rand() limit 1";
							$q2->query($query);
							$q2->next_record();
							if ($i==0)
							{
								$cookiecycle=$q2->f("cycle").":".$q2->f("id");
								$i=1;
							}
							else
							$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
							$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
						}
					}
					$ar_host=parse_url(get_setting("site_full_url"));
					$host=$ar_host["host"];
					$path=$ar_host["path"];
					$host=str_replace("www","",$host);
					if ($q->nf() != 0)
					$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto'");
					setcookie("cycle",base64_encode($cookiecycle),time()+7200, $path, $host);
						
				}
				else{
					$query="select id,cycle,text from cycle WHERE file='index.php' group by cycle";
					$q3->query($query);
						
					while ($q3->next_record())
					{
						$winner=get_setting("make_winner");
							
						if ( preg_match('/('.$q3->f("cycle").')\:(\d+)/',$winner,$match)){
							$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
							$q2->next_record();
							$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
						}
					}
					$cycle_name = explode("-",$cycle[0]);
					$t->set_var("cycle_".$cycle_name[1], $q->f("text"));
					for ($j=2 ; $j <= count($cycle)-1 ; $j++){
						$query="select text,file,cycle from cycle where id='$cycle[$j]'";
						$q3->query($query);
						$q3->next_record();
						$t->set_var("cycle_".$q3->f("cycle"), $q3->f("text"));
					}
				}
			}
		}
		//END CYCLER CODE				
		$_SESSION['second']=$_SESSION['second']+1;
		$ocontent=$t->parse("page", "content");
		$occ_buttons=explode("{OTO1}", "".$ocontent."");
		if (count($occ_buttons)>1) {
			$i=0;
			while ($i<(count($occ_buttons))-1) {
				$rez_button.=$occ_buttons[$i].get_pay_buttons($member_id, $product_id, $aff_id, $session, $step2, $i);
				$i++;
			}
		}
		$rez_button.=$occ_buttons[$i];
    print MWG::getInstance()->render($rez_button);
    exit();    
	}else{
		header("Location: continue.php");
	}
		
}else{
	get_logged_info();
	$member_id=$q->f("id");
	if (get_setting("enable_oto_1")==1 && ($seen==0 || $_SESSION['second']==1))
	{
		$t->set_file("content", "oto1.html");
		$ocontent=$t->parse("page", "content");
		$t->set_var("text_for_popup", get_setting("text_for_popup"));
		$t->set_var("text_no_buy", get_setting("text_no_buy"));
		$query="select * from products where nid='OTO1'";
		$q->query($query);
		$q->next_record();
		$product_id=$q->f("id");
		$aff_id=$_COOKIE["aff"];
		$session=new_sess_id();
		$step2=0;
		//START CYCLER CODE
		if (get_setting('activate_cycler')){
			if ($_COOKIE['cycle']=='')
			{
				$query="select * from cycle WHERE file='oto.php' group by cycle";
				$q->query($query);
				$i=0;
				while ($q->next_record())
				{
					$winner=get_setting("make_winner");
						
					if ( preg_match('/('.$q->f("cycle").')\:(\d+)/',$winner,$match)){
						$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
						$q2->next_record();
						$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
					}
					else{
						$query="select * from cycle where file='oto.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
						$q2->query($query);
						$q2->next_record();
						if ($q2->nf()){
							$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
						}else{
							$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
							$query="select * from cycle where file='oto.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
							$q2->query($query);
							$q2->next_record();
							$q3->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
						}
						if ($i==0)
						{
							$cookiecycle=$q2->f("cycle").":".$q2->f("id");
							$i=1;
						}
						else
						$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
						$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
					}
				}
				$ar_host=parse_url(get_setting("site_full_url"));
				$host=$ar_host["host"];
				$path=$ar_host["path"];
				$host=str_replace("www","",$host);
				if ($q->nf() != 0)
				$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto'");
				setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
			}
			else
			{
				$text=base64_decode($_COOKIE['cycle']);
				$cycle=explode(":", $text);
				$query="select text,file from cycle where id='".$cycle[1]."'";
				$q->query($query);
				$q->next_record();
				if ($q->f('file') != 'oto.php'){
					$query="select * from cycle WHERE file='oto.php' group by cycle";
					$q->query($query);
					$i=0;
					while ($q->next_record())
					{
						$winner=get_setting("make_winner");
							
						if ( preg_match('/('.$q->f("cycle").')\:(\d+)/',$winner,$match)){
							$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
							$q2->next_record();
							$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
						}
						else{
							$query="select * from cycle where file='oto.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
							$q2->query($query);
							$q2->next_record();
							if ($q2->nf()){
								$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
							}else{
								$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
								$query="select * from cycle where file='oto.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
								$q2->query($query);
								$q2->next_record();
								$q3->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
							}
							if ($i==0)
							{
								$cookiecycle=$q2->f("cycle").":".$q2->f("id");
								$i=1;
							}
							else
							$cookiecycle.=",".$q2->f("cycle").":".$q2->f("id");
							$t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
						}
					}
					$ar_host=parse_url(get_setting("site_full_url"));
					$host=$ar_host["host"];
					$path=$ar_host["path"];
					$host=str_replace("www","",$host);
					$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='oto'");
					setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
						
				}else{
					$query="select id,cycle,text from cycle WHERE file='oto.php' group by cycle";
					$q3->query($query);
						
					while ($q3->next_record())
					{
						$winner=get_setting("make_winner");
							
						if ( preg_match('/('.$q3->f("cycle").')\:(\d+)/',$winner,$match)){
							$q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
							$q2->next_record();
							$t->set_var("cycle_".$q2->f("cycle"),$q2->f("text"));
						}
					}
					$cycle_name = explode("-",$cycle[0]);
					$t->set_var("cycle_".$cycle_name[1], $q->f("text"));
					for ($j=2 ; $j <= count($cycle)-1 ; $j++){
						$query="select text,file,cycle from cycle where id='$cycle[$j]'";
						$q3->query($query);
						$q3->next_record();
						$t->set_var("cycle_".$q3->f("cycle"), $q3->f("text"));
					}
				}
			}
		}
		//END CYCLER CODE
		replace_tags_t($member_id, $t);
		$query="update members set seen=1 where id='$member_id'";
		$_SESSION['second']=$_SESSION['second'] + 1;
			
		$q->query($query);
		$ocontent=$t->parse("page", "content");
		$occ_buttons=explode("{OTO1}", "".$ocontent."");
		if (count($occ_buttons)>1) {
			$i=0;
			while ($i<(count($occ_buttons))-1) {
				$rez_button.=$occ_buttons[$i].get_pay_buttons($member_id, $product_id, $aff_id, $session, $step2, $i);
				$i++;
			}
			$rez_button.=$occ_buttons[$i];
		}else $rez_button.=$occ_buttons[0];
    print MWG::getInstance()->render($rez_button);
    exit();    
	}else{
		header("Location: continue.php");
	}
}

