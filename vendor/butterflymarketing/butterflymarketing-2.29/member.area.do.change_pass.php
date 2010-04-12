<?php
  
    include("inc.top.php");
    $q2 = new Cdb;
    get_logged_info(); //member area init...
    $member_id = $q->f("id");
  
    if (($new_pass == $re_pass) && $new_pass != "") {
        $q2->query("UPDATE members SET password=MD5('$new_pass') WHERE id='$member_id'");
        $err = 3;
    } else {
        $err = 2;
    }
 
    header("Location: member.area.change_pass.php?err=$err");
    exit;
?>
