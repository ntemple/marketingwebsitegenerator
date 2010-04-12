<?php 
	include("inc.top.php");
	$querystring = '';
	if ($signup_code == get_setting("signup_code")){
		$querystring = 'code=ok';echo 'code=ok';
	}else{
		$querystring = 'code=0';
	}
	foreach ($_GET as $name => $value){
		$querystring .= "&$name=$value";
	}
?>