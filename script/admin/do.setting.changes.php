<?php 
	include("inc.top.php");
	//Building Query for Settings Update
	$q2=new CDB;
	$q3=new CDB;
	
	$i = 0;
	$memberships = array();
	foreach ($_POST as $key=>$variable){
		preg_match ("'^membership_(\d+)'",$key,$match);
		if ($match[0]){
			$memberships[] = $match[1];
		}
		$i = 1;
	}
	
	$string = '';
	foreach ($memberships as $value){
		$string .= $value.",";
	}
	
	$string = substr($string,0,-1);
	
	$jv_custom_memberships = array();
	foreach ($_POST as $key=>$variable){
		preg_match ("'^jv_custom_membership_(\d+)'",$key,$match);
		if ($match[0]){
			$jv_custom_memberships[] = $match[1];
		}
		$i = 1;
	}
	
	$string2 = '';
	foreach ($jv_custom_memberships as $value){
		$string2 .= $value.",";
	}
	
	$string2 = substr($string2,0,-1);
	$k=1;
	
	$query="select * from settings where box_type!='hidden' and name not like '%_email%' or id=13 or id=9";
	$q->query($query);
	if ($i){
		while ($q->next_record())
		{
				if ($q->f("name")=="affiliate_variable"){ 
					if ($_POST[$q->f("name")]=='') $updatequery="update settings set value='r' where name='".$q->f("name")."'";
					else $updatequery="update settings set value='".addslashes($_POST['affiliate_variable'])."' where name='".$q->f("name")."'";
					$q3->query("SELECT value FROM settings WHERE name='affiliate_variable'");
					$q3->next_record();
					
					if ($q3->f('value') != $_POST['affiliate_variable']){
						$q2->query("UPDATE settings SET value='".$q3->f('value')."' WHERE name='old_aff'");
					}
				}elseif ($q->f("name")=="view_stats_chk"){
					$updatequery="update settings set value='$string' where name='".$q->f("name")."'";
				}elseif ($q->f("name")=="jv_custom_memberships"){
					$updatequery="update settings set value='$string2' where name='".$q->f("name")."'";
				}elseif ($q->f("name")=="captcha"){
					if (function_exists('imagecreate')) {
   							$updatequery="update settings set value='".addslashes($_POST[$q->f("name")])."' where name='".$q->f("name")."'";
								} else { $nogd=1;
								}	
				} elseif ($q->f("name")=="secret_string") {
					$updatequery="update settings set value='".addslashes($_POST[$q->f("name")])."' where name='".$q->f("name")."'";
					$q2->query($updatequery);
					if ($q->f("value")!=$_POST[$q->f("name")]) {
						$query="SELECT id FROM members";
						$q2->query($query);
						while ($q2->next_record()) {
							$member_id=$q2->f('id');
							$query="UPDATE members SET mdid='".md5(get_setting("secret_string").$q2->f("id"))."' WHERE id='$member_id'";
							mysql_query($query);
						}
					}
				}
				else $updatequery="update settings set value='".addslashes($_POST[$q->f("name")])."' where name='".$q->f("name")."'";
				$q2->query($updatequery);
			
				
		}
	}
	header("location:index.php?notemplate=$notemplate");
?>