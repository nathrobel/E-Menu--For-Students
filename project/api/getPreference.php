<?php
    if(!isset($_COOKIE['uuid'])){
        die("UUID not set!");
    }

    require_once("./connect.php");

    $query = "SELECT `preferences` FROM `uid` WHERE `uuid` = '".anti_injection($_COOKIE['uuid'])."';";
    $result = $conn->query($query);

    if ($result->num_rows != 1) {
        die('No result or multiple results found.');
    }
    $result->data_seek(0);
    $data = $result->fetch_array();

    echo $data['preferences'];
    exit();
?>