<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once 'connect.php';
    session_start();


    // ===================== Check id agriculturist =====================
    $stmt = $db->query("SELECT `money_type`, `money_list`, MONTH(`money_date`) as month, SUM(`money_quan`) as total FROM `money_inex` 
    WHERE MONTH(`money_date`) BETWEEN MONTH('2023-01-01') AND MONTH('2023-06-30') 
    GROUP BY `money_type`, `money_list` ,MONTH(`money_date`)");
    $stmt->execute();
    $arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $arr[] = $row;
    }
    $dataResultAll = json_encode($arr);
    echo $dataResultAll;
    
    
?>