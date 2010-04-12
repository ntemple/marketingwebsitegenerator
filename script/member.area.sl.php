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

 
include("inc.top.php");
$q2=new cdb;
$q3=new cdb;
	get_logged_info();
	$member_id=$q->f("id");
	$aff_id=$q->f("aff");
	$query="select * from membership where id='".$id."'";
	$q->query($query);
	$q->next_record();
	$query="select * from templates where id='".$q->f("template_id2")."'";
	$q->query($query);
	$q->next_record();
	$temp=$q->f("filename");
	replace_tags_t($member_id, $t);
	
	$t->set_file('content',$temp);
		//START CYCLER CODE
	if (get_setting('activate_cycler')){
		if ($_COOKIE['cycle']=='')
		{
			$query="select * from cycle WHERE file='salespage.php' group by cycle";
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
				$query="select * from cycle where file='salespage.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
				$q2->query($query);
				$q2->next_record();
				if ($q2->nf()){
					$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
				}else{
					$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
					$query="select * from cycle where file='salespage.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
	
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
			$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='index'");
			setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
		}
		else
		{
			$text=base64_decode($_COOKIE['cycle']);
				$cycle=explode(":", $text);
				$query="select text,file from cycle where id='$cycle[1]'";
				$q->query($query);
				$q->next_record();
				if ($q->f('file') != 'salespage.php'){
					
					$query="select * from cycle WHERE file='salespage.php' group by cycle";
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
						$query="select * from cycle where file='salespage.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
						$q2->query($query);
						$q2->next_record();
						if ($q2->nf()){
							$q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
						}else{
							$q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
							$query="select * from cycle where file='salespage.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
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
					$q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='index'");
					setcookie("cycle",base64_encode(mysql_insert_id()."-".$cookiecycle),time()+7200, $path, $host);
							
				}
				else{
				$query="select id,cycle,text from cycle WHERE file='oto2_bck.php' group by cycle";
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