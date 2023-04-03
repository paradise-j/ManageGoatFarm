<?php
    header('Content-Type: application/json; charset=utf-8');
    session_start();
    require_once('../connect.php');

    $id = $_SESSION['id'];
    $check_id = $db->prepare("SELECT `agc_id` FROM `user_login` WHERE user_login.user_id = '$id'");
    $check_id->execute();
    $row1 = $check_id->fetch(PDO::FETCH_ASSOC);
    extract($row1);


    $check_farm = $db->prepare("SELECT `gf_id` FROM `agriculturist` WHERE `agc_id` = '$agc_id'");
    $check_farm->execute();
    $row2 = $check_farm->fetch(PDO::FETCH_ASSOC);
    extract($row2);

    
    $sql = "SELECT `money_type`, MONTH(`money_date`) as month, SUM(`money_quan`) as total 
            FROM `money_inex` 
            INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id
            WHERE agriculturist.gf_id = '$gf_id'
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