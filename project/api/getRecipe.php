<?php
    require_once("./connect.php");
    require_once("./markdown.php");
    
    if(!isset($_GET['recipeid'])){
        die('Invalid request');
    }

    $query = "SELECT `content` FROM `recipe` WHERE `id`=".anti_injection($_GET['recipeid']).";";
    $result = $conn->query($query);

    if ($result->num_rows != 1) {
        die('No result or multiple results found. Contact Frank for assistance.');
    }
    $result->data_seek(0);
    $data = $result->fetch_array();

    $Parsedown = new Parsedown();
    $Parsedown->setSafeMode(true);
    echo $Parsedown->text($data['content']);
    exit();
?>