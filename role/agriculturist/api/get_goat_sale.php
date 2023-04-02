<?php
    header('Content-Type: application/json; charset=utf-8');
    session_start();
    require_once('../connect.php');

    $uid = $_SESSION['id'];
    // echo $uid;
    $sql = "SELECT MONTH(sale_date) as month , SUM(salelist.slist_price) as total 
            FROM `salelist` 
            INNER JOIN `sale` ON sale.sale_id = salelist.sale_id 
            INNER JOIN `agriculturist` ON sale.agc_id = agriculturist.agc_id 
            INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
            WHERE user_login.user_id = '$uid' 
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