<?php 
	include ("inc.top.php");
	$q=new Cdb;
	$q2=new CDb();
	$query="update members set membership_id='$moveto' where membership_id='$id'";
	$q->query($query);
	
	$query="SELECT * FROM members";
	$q2->query($query);
	while ($q2->next_record()) {
		if ($q2->f("membership_id")==$id) {
			updateHistory($q2->f("id"), $moveto, true);
			updateHistory($member_h_id, $id);
		}
	}
	
	
	$query="delete from membership where id='$id'";
	$q->query($query);
	header("location:membership.php");
?>