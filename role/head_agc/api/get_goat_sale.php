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
    
    $sql = "SELECT SUM(salelist.slist_price) as total , MONTH(sale_date) as month 
            FROM sale 
            INNER JOIN salelist ON sale.sale_id = salelist.sale_id 
            INNER JOIN `agriculturist` ON sale.agc_id = agriculturist.agc_id
            WHERE agriculturist.gf_id = '$gf_id'
            GROUP BY MONTH(sale_date)";
    $result = $db->query($sql);
    $result->execute();
    // $data = $result->fetch(PDO::FETCH_ASSOC);
    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $arr[] = $row;
    }
    echo json_encode($arr);
?>