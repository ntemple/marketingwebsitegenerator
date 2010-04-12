<?php 
	
	include("inc.top.php");
	$q->query("INSERT INTO member_notes SET message='".$_POST['notes']."', member_id='".$_GET['member_id']."', writer='".$_POST['admin']."', date=NOW()");
	
	
?>
<script>
window.self.close();window.opener.location.reload();
</script>
