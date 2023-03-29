<?php
    require_once 'connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'VMtype'){
        if($_POST['id'] == 1){
            echo '<option selected disabled>กรุณาเลือกผลิตภัณฑ์....</option>';
            $stmt = $db->query("SELECT * FROM `vc_data` WHERE `vc_type` = '1'");
            $stmt->execute();
            $vcs = $stmt->fetchAll();
            
            foreach($vcs as $vc){
                echo '<option value="'.$vc['vc_id'].'">'.$vc['vc_name'].'</option>';
                // echo '<option value="'.$amp['id'].'">'.$amp["name_th"].'</option>';
            }
        }else{
            echo '<option selected disabled>กรุณาเลือกผลิตภัณฑ์....</option>';
            $stmt = $db->query("SELECT * FROM `vc_data` WHERE `vc_type` = '2'");
            $stmt->execute();
            $vcs = $stmt->fetchAll();
            
            foreach($vcs as $vc){
                echo '<option value="'.$vc['vc_id'].'">'.$vc['vc_name'].'</option>';
            }
        }
        exit();
    }
?>