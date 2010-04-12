<?php
	include("inc.top.php");
	$q2=new CDB;
	$q3=new CDB;
	$q4=new CDB;
	$t->set_file("content", "admin.subscr.list.html");
	ffileread("../templates/admin.subscr.list.row.html",$row);
if($search>0){
	$q2->query("SELECT member_id,product_id,subscriber_id,cancelated FROM session WHERE subscriber_id='$search'");
	$q2->next_record();
	if($q2->nf()){
	$q3->query("SELECT id,email,first_name,last_name,aff,s_date,membership_id FROM members WHERE id='".$q2->f("member_id")."'");
	$q3->next_record();
		$rows.=str_replace("{id}",$q3->f("id"),$row);	
		$rows=str_replace("{first_name}",$q3->f("first_name"),$rows);
		$rows=str_replace("{last_name}",$q3->f("last_name"),$rows);
		$rows=str_replace("{email}",$q3->f("email"),$rows);
		$rows=str_replace("{aff}",$q3->f("aff"),$rows);
		$rows=str_replace("{s_date}",$q3->f("s_date"),$rows);
		$q4->query("SELECT name FROM membership WHERE id='".$q3->f("membership_id")."'");
		$q4->next_record();
		$rows=str_replace("{membership}",$q4->f("name"),$rows);
		$rows=str_replace("{subscriber_id}",$q2->f("subscriber_id"),$rows);
		$rows=str_replace("{product_id}",$q2->f("id"),$rows);
		if($q2->f("cancelated")==0) $rows=str_replace("{act}","<a href='cancel.auth.php?sid=".$q2->f("subscriber_id")."'>Cancel</a>",$rows);			
		else 	$rows=str_replace("{act}","Canceled",$rows);	
	}else $rows="<tr><td></td></tr><tr><td colspan='10' align='center'>No records found</td></tr>";		
}else{	
	if ($page<1) $page=1;
		$q2->query("SELECT member_id,subscriber_id,cancelated,products.id FROM session,products WHERE product_id = products.id AND subscriber_id!='' AND paid=1 AND recurring_auth=1 LIMIT ".(($page-1)*30).",30");
		while($q2->next_record()){
			$q3->query("SELECT id,email,first_name,last_name,aff,s_date,membership_id FROM members WHERE id='".$q2->f("member_id")."'");
			$q3->next_record();
			$rows.=str_replace("{id}",$q3->f("id"),$row);			
			$rows=str_replace("{first_name}",$q3->f("first_name"),$rows);
			$rows=str_replace("{last_name}",$q3->f("last_name"),$rows);
			$rows=str_replace("{email}",$q3->f("email"),$rows);
			$rows=str_replace("{aff}",$q3->f("aff"),$rows);
			$rows=str_replace("{s_date}",date("m/d/Y - h:i:s a",$q3->f("s_date")),$rows);
			$q4->query("SELECT name FROM membership WHERE id='".$q3->f("membership_id")."'");
			$q4->next_record();
			$rows=str_replace("{membership}",$q4->f("name"),$rows);
			$rows=str_replace("{subscriber_id}",$q2->f("subscriber_id"),$rows);
			if($q2->f("cancelated")==0) $rows=str_replace("{act}","<a href='cancel.auth.php?sid=".$q2->f("subscriber_id")."'>Cancel</a>",$rows);			
			else 	$rows=str_replace("{act}","Canceled",$rows);			
		}	
}
if($q2->nf()=='') $rows="<tr><td></td></tr><tr><td colspan='10' align='center'>No records found</td></tr>";
	$t->set_var("rows",$rows);
	if($page>1) $page_links.="<a href='subscr.list.php?page=".($page-1)."'>Previous page</a> ";
	if ($q2->nf()==30) $page_links.=" <a href='subscr.list.php?page=".($page+1)."'>Next page</a>";
	$t->set_var("pages",$page_links);
include('inc.bottom.php');
?>