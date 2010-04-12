<?php
	include ("inc.top.php");
	if ($processor==1) $up="cb_but";
	if ($processor==2) $up="2co_but";
	if ($processor==3) $up="pp_but";
	if ($processor==4) $up="auth_but";
	$query="update products set ".$up."='$img_id' where id='$id'";
	$q->query($query);
	header("location: products.buybutton.settings.php?id=".$id);
?>