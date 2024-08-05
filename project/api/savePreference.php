<?php
    exit();
	require_once("./postPreChecks.php");
	require_once("./connect.php");

    // Build query
    if(anti_injection($_POST)!==NULL){
        $query = "UPDATE `uid` SET `preferences` = '$_POST' WHERE `uuid` = '"$_COOKIE['uid']"';";
        $conn->query($query);
        echo "SUCCESS";
    } else {
        die("You must provide valid JSON data.");
    }
    exit();
?>