<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once 'connect.php';
    session_start();


    // ===================== Check id agriculturist =====================
    $stmt = $db->query("SELECT COUNT(`agc_id`) as total , group_farm.gf_name 
    FROM `agriculturist` 
    INNER JOIN `group_farm` ON group_farm.gf_id = agriculturist.gf_id 
    GROUP BY group_farm.gf_name");
    $stmt->execute();
    $arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $arr[] = $row;
    }
    $dataResultAll = json_encode($arr);
    echo $dataResultAll;
    
    
?>