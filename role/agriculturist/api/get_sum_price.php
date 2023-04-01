<?php
    header('Content-Type: application/json; charset=utf-8');
    session_start();
    // echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
    require_once('../connect.php');

    $uid = $_SESSION['id'];
    // echo $uid ;
    $sql = "SELECT group_g.gg_type , MONTH(sale.sale_date) as month , SUM(salelist.slist_price) as total FROM `salelist` 
                    INNER JOIN `group_g` ON group_g.gg_id = salelist.gg_id 
                    INNER JOIN `sale` ON sale.sale_id = salelist.sale_id 
                    INNER JOIN `agriculturist` ON sale.agc_id = agriculturist.agc_id 
                    INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
                    WHERE user_login.user_id = '$uid' 
                    GROUP BY group_g.gg_type , MONTH(sale.sale_date) ";

    $result = $db->query($sql);
    $result->execute();
    // $data = $result->fetch(PDO::FETCH_ASSOC);
    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $arr[] = $row;
    }
    echo json_encode($arr);
    // print_r($arr);
?>