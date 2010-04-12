<?php 
	
	include("inc.top.php");
	$q->query("UPDATE member_notes SET message='".$_POST['notes']."', writer='".$_POST['admin']."', date=NOW() WHERE id='".$_GET['note_id']."'");
	
	
?>
<script>
window.self.close();window.opener.location.reload()
</script>
