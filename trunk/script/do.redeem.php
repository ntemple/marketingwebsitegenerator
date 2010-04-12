<?php 
include("inc.all.php");
	get_logged_info(); //member area init...
	$id=$q->f("id");
	$query="select * from membership where promo_code='$promo'";
	$q->query($query);
	if ($q->nf()!=0 && $promo!="NONE" && trim($promo)!="")
	{
		$q->next_record();
		$query="update members set membership_id='".$q->f("id")."' where id='$id'";
		$q->query($query);
		updateHistory($id, $q->f("id"), true);
		
	}
	header("Location: member.area.membership.ag.php");
?>