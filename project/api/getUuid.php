<?php
    exit();
	require_once("./postPreChecks.php");
	require_once("./connect.php");
	
    if (isset($_COOKIE['uuid'])) {
        $query = "UPDATE `uid` WHERE `uuid`='".anti_injection($_COOKIE['uuid'])."';";
        $newUuid = $_COOKIE['uuid'];
    }
    else {
        // false, cookie is not set
        $newUuid = md5((string)(time()).$ip.(string)(rand()));
        $query = "INSERT INTO `uid` (`uuid`, `preferences`) VALUES ('".anti_injection($newUuid)."', '{}');";
    }

    $conn->query($query);
    
    $time = date(DATE_ATOM, mktime(date("G"), date("i"), date("s"), date("m"), date("d")+30, date("y")));
    $return = array('uuid'=>$newUuid, 'expire'=>$time);
    echo json_encode($return);
    exit();
?>