<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');
    $sql = "SELECT COUNT(`agc_id`) as total , group_farm.gf_name 
            FROM `agriculturist` 
            INNER JOIN `group_farm` ON group_farm.gf_id = agriculturist.gf_id 
            GROUP BY group_farm.gf_name";
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