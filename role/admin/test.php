<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once 'connect.php';
    session_start();


    // ===================== Check id agriculturist =====================
    $stmt = $db->query("SELECT group_g.gg_type , MONTH(sale.sale_date) as month , SUM(salelist.slist_price) as total
                        FROM `salelist` 
                        INNER JOIN `sale` ON sale.sale_id = salelist.sale_id
                        INNER JOIN `group_g` ON group_g.gg_id = salelist.gg_id 
                        INNER JOIN `agriculturist` ON group_g.agc_id = agriculturist.agc_id
                        INNER JOIN `group_farm` ON group_farm.gf_id = agriculturist.gf_id
                        WHERE group_farm.gf_id ='GF0006' AND MONTH(sale.sale_date) BETWEEN MONTH('2023-01-01') AND MONTH('2023-03-31')
                        GROUP BY  group_g.gg_type");
    $stmt->execute();
    $arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $arr[] = $row;
    }
    $dataResultAll = json_encode($arr);
    echo $dataResultAll;
    
    
?>