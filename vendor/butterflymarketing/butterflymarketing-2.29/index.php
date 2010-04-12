<?php
  
    if (file_exists('install')) {
        header('location: install/index.php');
        print "You MUST REMOVE the INSTALL directory before continuing";
        die();
    }
    include("inc.all.php");
    if (strpos($_SERVER['HTTP_HOST'], 'www.') === false) {
        if (strpos(get_setting('site_full_url'), 'www.')) {
            header("location:http://www.".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
            die();
        }
    } else {
        if (strpos(get_setting('site_full_url'), 'www.') === false) {
            header("location:http://".str_replace("www.", "", $_SERVER['HTTP_HOST']).$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
            die();
        }
    }
    $q3 = new CDb();
    $q2 = new CDb();
    $affiliate_var = get_setting("affiliate_variable");
    $affiliate_var2 = get_setting("old_aff");
    $ar_host = parse_url(get_setting("site_full_url"));
    $host = $ar_host["host"];
    $path = $ar_host["path"];
    $host = str_replace("www", "", $host);
    if ($_GET[$affiliate_var] != "" || $_GET[$affiliate_var2] != "") {
        setcookie("aff", ($_GET[$affiliate_var] ? $_GET[$affiliate_var] :$_GET[$affiliate_var2]), time()+9999999, $path, $host);
    }
    if ($_GET[$affiliate_var] != "" || $_GET[$affiliate_var2] != "") {
        header("Location: index.php");
    }
 
    $t->set_file("content", "homepage.html");
    if (get_setting("index_signup")) {
        if (get_setting("free_signup") == 1) {
            $t->set_file("signupform", "signup.html");
       
            $t->set_file("signuplist", "signup.row.html");
            $t->set_file("signuplist_b", "signup.row.html");
            $t->set_file("confirmpass", "confirm.pass.html");
            include("signup.kit.php");
        } else {
            $t->set_file('signupform', "signup.paid.html");
            
        }
        $t->parse("signup_form", "signupform", true);
    }
    //START CYCLER CODE
    if (get_setting('activate_cycler')) {
        if ($_COOKIE['cycle'] == '') {
            $query = "select * from cycle WHERE file='index.php' group by cycle";
            $q->query($query);
            $i = 0;
            while ($q->next_record()) {
                $winner = get_setting("make_winner");
                if (preg_match('/('.$q->f("cycle").')\:(\d+)/', $winner, $match)) {
                    $q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
                    $q2->next_record();
                    $t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
                } else {
                    $query = "select * from cycle where file='index.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
                    $q2->query($query);
                    $q2->next_record();
                    if ($q2->nf()) {
                        $q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
                    } else {
                        $q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
                        $query = "select * from cycle where file='index.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
                        $q2->query($query);
                        $q2->next_record();
                    }
                    if ($i == 0) {
                        $cookiecycle = $q2->f("cycle").":".$q2->f("id");
                        $i = 1;
                    }
                    else
                        $cookiecycle .= ",".$q2->f("cycle").":".$q2->f("id");
                    $t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
                }
            }
            $ar_host = parse_url(get_setting("site_full_url"));
            $host = $ar_host["host"];
            $path = $ar_host["path"];
            $host = str_replace("www", "", $host);
            if ($q->nf() != 0)
                $q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='index'");
            setcookie("cycle", base64_encode(mysql_insert_id()."-".$cookiecycle), time()+7200, $path, $host);
        } else {
            $text = base64_decode($_COOKIE['cycle']);
            $cycle = explode(":", $text);
            $query = "select text,file from cycle where id='$cycle[1]'";
            $q->query($query);
            $q->next_record();
            if ($q->f('file') != 'index.php') {
                $query = "select * from cycle WHERE file='index.php' group by cycle";
                $q->query($query);
                $i = 0;
                while ($q->next_record()) {
                    $winner = get_setting("make_winner");
                    if (preg_match('/('.$q->f("cycle").')\:(\d+)/', $winner, $match)) {
                        $q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
                        $q2->next_record();
                        $t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
                    } else {
                        $query = "select * from cycle where file='index.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
                        $q2->query($query);
                        $q2->next_record();
                        if ($q2->nf()) {
                            $q2->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
                        } else {
                            $q2->query("UPDATE cycle SET display=0 WHERE cycle='".$q->f("cycle")."'");
                            $query = "select * from cycle where file='index.php' AND cycle='".$q->f("cycle")."' AND display=0 order by id limit 1";
                            $q2->query($query);
                            $q2->next_record();
                            $q3->query("UPDATE cycle SET display=1 WHERE id='".$q2->f("id")."'");
                        }
                        if ($i == 0) {
                            $cookiecycle = $q2->f("cycle").":".$q2->f("id");
                            $i = 1;
                        }
                        else
                            $cookiecycle .= ",".$q2->f("cycle").":".$q2->f("id");
                        $t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
                    }
                }
                $ar_host = parse_url(get_setting("site_full_url"));
                $host = $ar_host["host"];
                $path = $ar_host["path"];
                $host = str_replace("www", "", $host);
                if ($q->nf() != 0)
                    $q2->query("INSERT INTO cycle_stats SET value='".$cookiecycle."', page='index'");
                setcookie("cycle", base64_encode(mysql_insert_id()."-".$cookiecycle), time()+7200, $path, $host);
            } else {
                $query = "select id,cycle,text from cycle WHERE file='index.php' group by cycle";
                $q3->query($query);
                while ($q3->next_record()) {
                    $winner = get_setting("make_winner");
                    if (preg_match('/('.$q3->f("cycle").')\:(\d+)/', $winner, $match)) {
                        $q2->query("select id,cycle,text from cycle WHERE id='".$match[2]."'");
                        $q2->next_record();
                        $t->set_var("cycle_".$q2->f("cycle"), $q2->f("text"));
                    }
                }
                $cycle_name = explode("-", $cycle[0]);
                $t->set_var("cycle_".$cycle_name[1], $q->f("text"));
                for ($j = 2 ; $j <= count($cycle)-1 ; $j++) {
                    $query = "select text,file,cycle from cycle where id='$cycle[$j]'";
                    $q3->query($query);
                    $q3->next_record();
                    $t->set_var("cycle_".$q3->f("cycle"), $q3->f("text"));
                }
            }
        }
    }
    //END CYCLER CODE
    include("inc.bottom.php");
?>