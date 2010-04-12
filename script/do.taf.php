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

 
include ("inc.top.php");
get_logged_info();
$name=$q->f("first_name")." ".$q->f("last_name");
$email=$q->f("email");
if (get_setting("enable_captcha_taf")==1)	{
	require_once("lib/hn_captcha.class.x1.php");
	// ConfigArray
	$folders=get_setting("site_full_url");
	$folders=preg_replace('/http\:\/\/'.$_SERVER['HTTP_HOST'].'/',"",$folders);
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
	$captcha =& new hn_captcha($CAPTCHA_INIT);
$validate=$captcha->validate_submit();
}else $validate=1;
switch($validate)
	{
		// was submitted and has valid keys
		case 1:
				if ($namex1!="" && $emailx1!="")
				{
					$subject=$value1;
					$body=$value2;
					$subject=str_replace("[FIRSTNAME]", $namex1, $subject);
					$body=str_replace("[FIRSTNAME]", $namex1, $body);
					@mail($emailx1, stripslashes($subject), stripslashes($body), "From: $name<$email>");
					
				}
				if ($namex2!="" && $emailx2!="")
				{
					$subject=$value1;
					$body=$value2;
					$subject=str_replace("[FIRSTNAME]", $namex2, $subject);
					$body=str_replace("[FIRSTNAME]", $namex2, $body);
					@mail($emailx2, stripslashes($subject), stripslashes($body), "From: $name<$email>");
				}
				if ($namex3!="" && $emailx3!="")
				{
					$subject=$value1;
					$body=$value2;
					$subject=str_replace("[FIRSTNAME]", $namex3, $subject);
					$body=str_replace("[FIRSTNAME]", $namex3, $body);
					@mail($emailx3, stripslashes($subject), stripslashes($body), "From: $name<$email>");
				}
				if ($namex4!="" && $emailx4!="")
				{
					$subject=$value1;
					$body=$value2;
					$subject=str_replace("[FIRSTNAME]", $namex4, $subject);
					$body=str_replace("[FIRSTNAME]", $namex4, $body);
					@mail($emailx4, stripslashes($subject), stripslashes($body), "From: $name<$email>");
				}
				if ($namex5!="" && $emailx5!="")
				{
					$subject=$value1;
					$body=$value2;
					$subject=str_replace("[FIRSTNAME]", $namex5, $subject);
					$body=str_replace("[FIRSTNAME]", $namex5, $body);
					@mail($emailx5, stripslashes($subject), stripslashes($body), "From: $name<$email>");
				}
				header("location: member.area.promo.tools.php");
	break;
	case 2:
			$str=$_SERVER['HTTP_REFERER'];
			$str= str_replace("&captcha=1","",$str);$str= str_replace("&captcha=2","",$str);
			$str= str_replace("?captcha=1","",$str);$str= str_replace("?captcha=2","",$str);	
						if (strpos($str,"?"))
							die("<script>
									parent.document.location='".$str."&captcha=1$double';					
								</script>");
						else 
							die("<script>
									parent.document.location='".$str."?captcha=1$double';					
								</script>");
			break;
	
	
		// was submitted, has bad keys and also reached the maximum try's
		case 3:
		
			
			$str=$_SERVER['HTTP_REFERER'];
			$str= str_replace("&captcha=1","",$str);$str= str_replace("&captcha=2","",$str);
			$str= str_replace("?captcha=1","",$str);$str= str_replace("?captcha=2","",$str);
						if (strpos($str,"?"))
							die("<script>
									parent.document.location='".$str."&captcha=2$double';					
								</script>");
						else 
							die("<script>
									parent.document.location='".$str."?captcha=2$double';					
								</script>");
//			echo "You have reached the maximum tries... you cannot signup at this time";
			break;
		// was not submitted, first entry
	}
?>