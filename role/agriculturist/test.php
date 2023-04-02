<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once 'connect.php';
    session_start();


    // ===================== Check id agriculturist =====================
    $stmt = $db->query("SELECT `money_list`, MONTH(`money_date`) as month, SUM(`money_quan`) as total 
    FROM `money_inex` 
    INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id
    INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
    WHERE user_login.user_id = 'US0007' AND `money_type`= '2' AND MONTH(`money_date`) BETWEEN MONTH('2023-01-01') AND MONTH('2023-04-30')  
    GROUP BY `money_list`, MONTH(`money_date`)
    ORDER BY MONTH(`money_date`)");
    $stmt->execute();
    $arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $arr[] = $row;
    }
    $dataResultAll = json_encode($arr);
    echo $dataResultAll;
?>