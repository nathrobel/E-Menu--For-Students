<?php
    require_once("./connect.php");
    if(!isset($_GET['recipeid'])){
        die('Invalid request');
    }

    $query = "SELECT * FROM `recipe` WHERE `id`=".anti_injection($_GET['recipeid']).";";
    $query_tag = "SELECT `tag` FROM `recipe_terms` WHERE `menu`=".anti_injection($_GET['recipeid']).";";
    $result = $conn->query($query);
    $result_tag = $conn->query($query_tag);

    if ($result->num_rows != 1) {
        die('No result or multiple results found.');
    }
    $result->data_seek(0);
    $data = $result->fetch_array();
    
    $tags = array();
    for ($x = 0; $x < $result_tag->num_rows; $x++) {
        $result_tag->data_seek($x);
        $tag_data = $result_tag->fetch_array();
        array_push($tags, (int)$tag_data['tag']);
    }

    $array = array('id'=>(int)(anti_injection($_GET['recipeid'])), 'name'=>$data['name'], 'img'=>$data['cover'], 'description'=>$data['description'], 'source'=>$data['source'], 'author'=>$data['author'], 'category'=>$tags, 'time'=>(int)$data['time'], 'calorie'=>(int)$data['calorie']);
    echo json_encode($array);
    exit();
?>