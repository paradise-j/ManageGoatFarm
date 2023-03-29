<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');
    $sql = "SELECT SUM(salelist.slist_price) as total , MONTH(sale_date) as month FROM sale INNER JOIN salelist ON sale.sale_id = salelist.sale_id GROUP BY MONTH(sale_date)";
    $result = $db->query($sql);
    $result->execute();
    // $data = $result->fetch(PDO::FETCH_ASSOC);
    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $arr[] = $row;
    }
    echo json_encode($arr);
?>