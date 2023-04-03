<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once 'connect.php';
    session_start();


    // ===================== Check id agriculturist =====================
    $stmt = $db->query("SELECT `money_list` , SUM(`money_quan`) as total 
                        FROM `money_inex` 
                        WHERE `money_type`= '3' AND MONTH(`money_date`) BETWEEN MONTH('2023-01-01') AND MONTH('2023-04-30')
                        GROUP BY `money_list`");
    $stmt->execute();
    $arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $arr[] = $row;
    }
    $dataResultAll = json_encode($arr);
    echo $dataResultAll;
    
    
?>