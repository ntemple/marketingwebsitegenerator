<?php 
	
	include("inc.top.php");
	
	$q2 = new cdb;
	
	$query="SELECT * FROM members";
	$q->query($query);
	if ($q->nf()!=0) {
		while ($q->next_record()) {
			if ($q->f('msg_viewed')) {
				$member_id=$q->f('id');
				$msg_array=explode(',',$q->f('msg_viewed'));
				for ($j=0;$j<count($msg_array)-1;$j++){
					if ($msg_array[$j]!=$id) {
						$new_msg_viewed.=$msg_array[$j].",";
					}
				}
				$q2->query("UPDATE members SET msg_viewed="."'".$new_msg_viewed."' WHERE id='".$q->f("id")."'");
			}
		}
	}
	header("Location: login_msg.php");
	
?>