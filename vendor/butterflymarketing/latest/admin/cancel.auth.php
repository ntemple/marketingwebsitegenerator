<?php
    
    include("inc.all.php");
    require_once("../lib/AuthnetARB.class.php");
    $q2 = new CDb();
    $q3 = new CDb();
	$login = get_setting('auth_login_arb');
    $transkey = get_setting('auth_key_arb');
    $test = get_setting('auth_test2') ? true : false;
    $arb = new AuthnetARB($login, $transkey, $test);
    $arb->setParameter('refID', 'none');
    $arb->setParameter('subscrId', $_GET['sid']);
    $arb->deleteAccount();
    if ($arb->isSuccessful()) {
    	$query="UPDATE session SET cancelated=1 WHERE subscriber_id='".$_GET['sid']."'";
    	mysql_query($query);
        $comment="Recurring payment was cancel by admin. Product:".$q2->f("display_name")." Member id: $s_member_id_new";
    	$query="INSERT INTO payment_log SET 
    	stamp='".time()."', 
    	ip='".getenv('REMOTE_ADDR')."', 
    	product='".$product_display_name."', 
    	txn_id='admin transaction', 
    	comment='$comment', 
    	process_type='Authorize.net'
    	";
    	mysql_query($query);
    	header("Location:subscr.list.php?menu=members");
    	die();
    } else {
    	$errors = 'isError: '.$arb->isError().' | SubscriberID: '.$arb->getSubscriberID().' | Response: '.$arb->getResponse().'ResultCode:'.$arb->getResultCode().'getString: '.$arb->getString().'RawResponse: '.$arb->getRawResponse();
    	echo $errors;
    }
 ?>
