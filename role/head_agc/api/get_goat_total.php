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


    $sql = "SELECT SUM(gg_quantity) as total,gg_type 
            FROM `group_g` 
            INNER JOIN `agriculturist` ON group_g.agc_id = agriculturist.agc_id
            WHERE agriculturist.gf_id = '$gf_id'
            GROUP BY gg_type";
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