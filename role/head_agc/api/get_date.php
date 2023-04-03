<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    // echo $start_date;
    // echo $end_date;


    $sql = "SELECT SUM(salelist.slist_price) as total , MONTH(sale_date) as month 
            FROM `sale` 
            INNER JOIN `salelist` ON sale.sale_id = salelist.sale_id 
            WHERE MONTH(sale_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
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