<?php
include ("inc.top.php");
get_logged_info();
$membership_id=$q->f("membership_id");
$b= $_SERVER['PHP_SELF'];
while (strpos($b, "/")!== false)
{
	$c=strstr($b,"/");
	$c=substr($c, 1);
	$b=$c;
}
	if ($q->f("history")!="") {
		$member_history=explode(",", $q->f("history"));
	} else {
		updateHistory($member_id, $member_membership_id, true);
		updateHistory($member_id, get_setting("default_free"), true);
		get_logged_info();
		$member_history=explode(",", $q->f("history"));
	}
	$membership_history=$member_history;
	$show_item=array();
	
foreach ($membership_history as $value) {
	if ($value!="") {
		$show_item[]=$value;
	}
}
	
	$show_item=array_unique($show_item);
$b=str_replace(".php","",$b);
$query="select * from downloadprotect where link='$b'";
$q->query($query);
$q->next_record();
if (array_search($q->f("membership_id"), $show_item)!==false)
{
	$local_file = "download/".$q->f("file");
	$download_file = $q->f("memberfile");
	
	// set the download rate limit (=> 20,5 kb/s)
	$download_rate = 500;
	if(file_exists($local_file) && is_file($local_file))
	{
	    header('Cache-control: private');
	    header('Content-Type: application/octet-stream');
	    header('Content-Length: '.filesize($local_file));
	    header('Content-Disposition: filename='.$download_file);
	
	    flush();
	    $file = fopen($local_file, "r");
	    while(!feof($file))
	    {
	        // send the current file part to the browser
	        print fread($file, round($download_rate * 1024));
	        // flush the content to the browser
	        flush();
	        // sleep one second
	        sleep(1);
	    }
	    fclose($file);
	}
	else {
	    die('Error: The file '.$local_file.' does not exist!');
	}
} else {
	die("<center><font color='red'><b>You don't have required membership to access this page!</font></b></center>");
}
?>