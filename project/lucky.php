<?php
    require_once("./api/connect.php");
    $query = "SELECT `id` FROM `recipe`";
    $result = $conn->query($query);
    $array = [];
    while($row = $result->fetch_array()){
        array_push($array, $row['id']);
    }
    header('Location: /recipe.html?recipeid='.$array[array_rand($array, 1)]);
?>