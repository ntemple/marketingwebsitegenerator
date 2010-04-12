<?php 
	include("inc.top.php");
	
	$q->query("SELECT * FROM countries order by country asc");
	$for_query = '';
	while ($q->next_record()){
		if ($_POST['country_'.$q->f('id')]){
			$for_query .= $_POST['fee_'.$q->f('id')].";".$q->f('id')."|";
		}
	}
	$for_query = substr($for_query,0,-1);
	$query="update products set fee='$for_query' where id='".$_POST['id']."'";
	$q->query($query);
		
echo "<script>window.self.close();</script>";
	
?>