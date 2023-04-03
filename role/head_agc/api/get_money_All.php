<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');
    $sql = "SELECT `money_type`, MONTH(`money_date`) as month, SUM(`money_quan`) as total FROM `money_inex` GROUP BY `money_type`,MONTH(`money_date`)";
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