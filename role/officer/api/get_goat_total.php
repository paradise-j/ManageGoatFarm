<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');
    $sql = "SELECT SUM(gg_quantity) as total,gg_type FROM `group_g` GROUP BY gg_type";
    $result = $db->query($sql);
    $result->execute();
    // $data = $result->fetch(PDO::FETCH_ASSOC);
    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $arr[] = $row;
    }
    // echo "<pre>";   
    echo json_encode($arr);
?>