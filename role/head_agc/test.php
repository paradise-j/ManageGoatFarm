<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once 'connect.php';
    session_start();


    // ===================== Check id agriculturist =====================
    $stmt = $db->query("SELECT `money_list`, `money_date` as month, SUM(`money_quan`) as total 
    FROM `money_inex` 
    WHERE `money_type`= '2' AND `money_date` BETWEEN '2023-01-01' AND '2023-12-30' 
    GROUP BY `money_list`,`money_date`");
    $stmt->execute();
    $arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $arr[] = $row;
    }
    $dataResultAll = json_encode($arr);
    echo $dataResultAll;
    
    
?>