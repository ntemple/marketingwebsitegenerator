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
$q3=new Cdb;
	$ar_host=parse_url(get_setting("site_full_url"));
	$host=$ar_host["host"];
	$path=$ar_host["path"];
	$host=str_replace("www","",$host);
	if (get_setting("free_signup")==1)
	{
		
		$t->set_file("content", "signup.html");
		$t->set_file("signuplist", "signup.row.html");
		$t->set_file("signuplist_b", "signup.row.html");
		$t->set_file("confirmpass", "confirm.pass.html");
		
		include("signup.kit.php");
		
	}
	else
	{ 
		$t->set_file('content',"signup.paid.html");
	}
		//START CYCLER CODE
	if (get_setting('activate_cycler')){
		if ($_COOKIE['cycle']=='')
		{
			$query="select * from cycle WHERE file='signup.php' group by cycle";
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
				$query="select * from cycle where file='signup.php' AND cycle='".$q->f("cycle")."' order by rand() limit 1";
				$q2->query($query);
				$q2->next_record();
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
			$ar_host=parse_url(get_setting("site_full_url"));
			$host=$ar_host["host"];
			$path=$ar_host["path"];
			$host=str_replace("www","",$host);
			if ($q->nf() != 0)
				$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='signup'");
			setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
		}
		else
		{
			$text=base64_decode($_COOKIE['cycle']);
				$cycle=explode(":", $text);
				$query="select text,file from cycle where id='".$cycle[count($cycle)-1]."'";
				$q->query($query);
				$q->next_record();
				if ($q->f('file') == 'index.php'){
					$cycle_arr_first = explode("-",$cycle[0]);
					$q2->query("UPDATE cycle_stats SET used=1 WHERE id='".$cycle_arr_first[0]."'");
				}
				if ($q->f('file') != 'signup.php'){
					
					$query="select * from cycle WHERE file='signup.php' group by cycle";
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
						$query="select * from cycle where file='signup.php' AND cycle='".$q->f("cycle")."' order by rand() limit 1";
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
						$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='signup'");
					setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
							
				} else{
					$query="select id,cycle,text from cycle WHERE file='signup.php' group by cycle";
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
include("inc.bottom.php");
?>