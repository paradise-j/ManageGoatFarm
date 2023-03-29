<?php
    header('Content-Type: application/json; charset=utf-8');
    session_start();
    require_once('../connect.php');

    $uid = $_SESSION['id'];
    $sql = "SELECT `money_type`, MONTH(`money_date`) as month, SUM(`money_quan`) as total 
            FROM `money_inex` 
            INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id 
            INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
            WHERE user_login.user_id = '$uid' 
            GROUP BY `money_type`,MONTH(`money_date`)";
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