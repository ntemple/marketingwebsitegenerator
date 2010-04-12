<?php 
	include("inc.top.php");
	if($id!=''){
		$q->query("UPDATE a_tr SET admin_note='".$note."' WHERE id='".$id."'");
	}elseif($member_id!=''){
		$q->query("UPDATE a_tr SET admin_note=CONCAT(admin_note,'".$note."') WHERE member_id='".$member_id."' and status=1 and dt>='".$start."' and dt<'".$end."'");
}
?>
<script>
window.opener.location.reload();window.self.close();
</script>