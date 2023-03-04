<?php 
    session_start();
    require_once "connect.php";

        $Gtype = "3";
        $range_age = "5";


        $VM = $db->prepare("SELECT * FROM `group_g`");
        $VM->execute();

        while ($row = $VM->fetch(PDO::FETCH_ASSOC)) {
            if($Gtype == $row["gg_type"] and $range_age == $row["gg_range_age"]){
                $gg_id = $row["gg_id"];
                echo $gg_id;
                break;
            }
        }
?>