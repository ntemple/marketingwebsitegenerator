<?php 
include("inc.top.php");
	 get_logged_info();
	 $q2=new CDB;
	 $query="SELECT id FROM menus WHERE link='member.area.promo.tools.php'";
	 $q2->query($query);
	 $q2->next_record();
	 $query="SELECT membership_id FROM menu_permissions WHERE menu_item='".$q2->f("id")."'";
	 $q2->query($query);
	 while ($q2->next_record()) {
	 	$permissions[]=$q2->f("membership_id");
	 }
	 if (count($permissions)>0) {
	 	$error='<center><font color="red"><b>You do not have access to this area!<br><br>Upgrade your membership level!</b></font></center>';
	 	foreach ($permissions as $value) {
	 		if ($value==$q->f("membership_id")) {
	 			$error='';
	 			break;
	 		}
		}
		if ($error!="") {
			die("$error");
		}
	 }
	
	$member_id=$q->f("id");
	
	$t->set_file("content", "member.area.promo.tools.html");
	$t->set_file("category_template", "member.area.promo.tools.category.html");
	$t->set_file("item_template", "member.area.promo.tools.item.html");
	
	$query="select * from promo_tools where template<>1 order by rank ";
	
	$q->query($query);
	
	if ($q->nf()==0) die("No data for promo tools.");
	
	$q->next_record();
	
	$curr_category=$q->f("category");
	$t->set_var("category", $q->f("category"));
	
	$t->parse("promo_tools_list", "category_template", true);
	
	$t->set_var("tool", $q->f("content"));
	$t->parse("promo_tools_list", "item_template", true);
	
	while ($q->next_record())
	{
		if ($q->f("category")!=$curr_category)
		{
			$curr_category=$q->f("category");
			$t->set_var("category", $q->f("category"));
			
			$t->parse("promo_tools_list", "category_template", true);
		}
		
		$t->set_var("tool", $q->f("content"));
		$t->parse("promo_tools_list", "item_template", true);
		
	}
	
	$aff_link=get_aff_link($member_id);
	
	replace_tags_t($member_id, $t);
if (get_setting("enable_captcha_taf")==1)	{
	require_once("lib/hn_captcha.class.x1.php");
	if ($_GET['captcha']==1) { 
		$error.='<script language="Javascript">alert("Captcha code incorrectly entered");</script>';
	}
$folders=get_setting("site_full_url");
$folders=str_replace("http://".$_SERVER['HTTP_HOST'],"",$folders);
	$CAPTCHA_INIT = array(
            'tempfolder'     => $_SERVER['DOCUMENT_ROOT'].$folders."_tmp/",      // string: absolute path (with trailing slash!) to a writeable tempfolder which is also accessible via HTTP!
			'TTF_folder'     => $_SERVER['DOCUMENT_ROOT'].$folders."fonts/", // string: absolute path (with trailing slash!) to folder which contains your TrueType-Fontfiles.
                                // mixed (array or string): basename(s) of TrueType-Fontfiles
//			'TTF_RANGE'      => array('comic.ttf','impact.ttf','LYDIAN.TTF','MREARL.TTF','RUBBERSTAMP.TTF','ZINJARON.TTF'),
			'TTF_RANGE'      => array('comic.ttf','impact.ttf'),
            'chars'          => 5,       // integer: number of chars to use for ID
            'minsize'        => 20,      // integer: minimal size of chars
            'maxsize'        => 30,      // integer: maximal size of chars
            'maxrotation'    => 25,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30
            'noise'          => TRUE,    // boolean: TRUE = noisy chars | FALSE = grid
            'websafecolors'  => FALSE,   // boolean
            'refreshlink'    => TRUE,    // boolean
            'lang'           => 'en',    // string:  ['en'|'de']
            'maxtry'         => 3,       // integer: [1-9]
            'badguys_url'    => '/',     // string: URL
            'secretstring'   => 'A very, very secret string which is used to generate a md5-key!',
            'secretposition' => 24,      // integer: [1-32]
            'debug'          => FALSE,
	);
	$captcha =& new hn_captcha_X1($CAPTCHA_INIT);
	$t->set_var("captcha",$captcha->display_form());
}else $t->set_var("captcha","");
	
if ($error) echo $error;
	include("inc.bottom.php");
?>