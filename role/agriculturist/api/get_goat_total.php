<?php
    header('Content-Type: application/json; charset=utf-8');
    session_start();
    require_once('../connect.php');

    $uid = $_SESSION['id'];
    // echo $uid ;   
    $sql = "SELECT gg_type , SUM(gg_quantity) as total
            FROM `group_g` 
            INNER JOIN `agriculturist` ON group_g.agc_id = agriculturist.agc_id 
            INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
            WHERE user_login.user_id = '$uid' 
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
    // print_r($arr);
?>