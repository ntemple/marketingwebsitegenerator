<?php
	include("inc.top.php");
	$q2= new Cdb;
	
	$query="update products set cb_but=0 where cb_but='$img_id2' and id='$id'";
	$q->query($query);
	
	$query="update products set 2co_but=0 where 2co_but='$img_id2' and id='$id'";
	$q->query($query);
	$query="update products set pp_but=0 where pp_but='$img_id2' and id='$id'";
	$q->query($query);
	$query="delete from buybuttons where id = '$img_id2'";
	$q->query($query);
	
	header("location: products.buybutton.settings.php?id=".$id);
	
	
	
	
?>