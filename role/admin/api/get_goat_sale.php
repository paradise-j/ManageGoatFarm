<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');
    $sql = "SELECT SUM(`slist_price`) as total , group_g.gg_type 
                    FROM `salelist`
                    INNER JOIN `group_g` ON salelist.gg_id = group_g.gg_id 
                    GROUP BY `gg_type`";
    $result = $db->query($sql);
    $result->execute();
    // $data = $result->fetch(PDO::FETCH_ASSOC);
    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $arr[] = $row;
    }
    echo json_encode($arr);
?>