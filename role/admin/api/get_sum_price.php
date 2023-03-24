<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');
    $sql = "SELECT group_g.gg_type , MONTH(sale.sale_date) as month , SUM(salelist.slist_price) as total
            FROM salelist 
            INNER JOIN group_g ON group_g.gg_id = salelist.gg_id 
            INNER JOIN sale ON sale.sale_id = salelist.sale_id 
            GROUP BY MONTH(sale.sale_date)
            ORDER BY group_g.gg_type";
    $result = $db->query($sql);
    $result->execute();
    // $data = $result->fetch(PDO::FETCH_ASSOC);
    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $arr[] = $row;
    }
    echo json_encode($arr);
?>