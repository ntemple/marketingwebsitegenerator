<?php 
include("inc.top.php");
	$t->set_file("content", "admin.log.html");
	$t->set_file("messagesrows", "admin.log.rows.html");
	
	$where = "1=1 ";
	if ($date){
		$start=mktime(0,0,0,$month_start, $day_start, $year_start);
		$end=mktime(0,0,0,$month_end, $day_end, $year_end);
		$where .= "AND stamp >$start and  stamp < $end";
	}
	$q->query("SELECT id,  display_name FROM products");
	$option = "";
	while ($q->next_record()){
		$option .= "<option value='".$q->f("display_name")."' >".$q->f("display_name")."</option>";
	}
	$t->set_var("product_names", $option);
	
	if ($product_chk){
		$where .= " AND product LIKE '".$product."'";
	}
	
	if ($fraud_chk){
		$where .= " AND comment LIKE '%Attempt%'";
	}
	
	if ($member_chk){
		$where .= " AND comment LIKE '%$member_id_log%'";
	}
	
	if ($txn_chk){
		$where .= " AND txn_id='".$txn."'";
	}
	if (strlen($where)<5){
	$limit='limit 0,5';
	}
	else $limit='';
	$q->query("SELECT * FROM payment_log WHERE $where ORDER BY stamp DESC $limit");
	if ($q->nf() == 0){
		$t->set_var("messages_rows", "");
	}
	while ($q->next_record()){
		$t->set_var("id", $q->f("id"));
		$t->set_var("merchant", $q->f("process_type"));
		$t->set_var("txn", $q->f("txn_id"));
		$t->set_var("message", $q->f("comment"));
		$t->set_var("product", $q->f("product"));
		$t->set_var("ip", $q->f("ip"));
		$t->set_var("date", date("m/d/Y - g:i a", $q->f("stamp")));
		
		preg_match("'member: (\d+)'",$q->f("comment"), $match);
	 	$t->set_var("member",$q->f("buyer_id") ? $q->f("buyer_id") : $match [1] );
		preg_match("'Attempt'",$q->f("comment"), $match);
		if ($match [0])
	 		$t->set_var("attempt","<b>Fraud Attempt</b>");
	 	else 
	 		$t->set_var("attempt","No Fraud");
	
		$t->parse("messages_rows", "messagesrows",true);
	}
	
include("inc.bottom.php");
?>
