<?php
	require_once("./connect.php");
	
    $tax_query = "SELECT * FROM `tax`;";
    $tax_result = $conn->query($tax_query);
    
    $result = [];
    for ($x = 0; $x < $tax_result->num_rows; $x++) {
        $tax_result->data_seek($x);
        $tax_data = $tax_result->fetch_array();
        
        $query_tag = "SELECT * FROM `tag` WHERE `father`=".$tax_data['id'].";";
        $result_tag = $conn->query($query_tag);
        $tags = array();
        for ($y = 0; $y < $result_tag->num_rows; $y++) {
            $result_tag->data_seek($y);
            $tag_data = $result_tag->fetch_array();
            array_push($tags, ['id'=>(int)$tag_data['id'], 'name'=>$tag_data['name']]);
        }
        
        $curr_tax = ['id' => $tax_data['id'], 'name' => $tax_data['name'], 'elements' => $tags];
        array_push($result, $curr_tax);
    }

    echo json_encode($result);
    exit();
?>