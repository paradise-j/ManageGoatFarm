<?php
    require_once 'connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'typefg'){
        $id = $_POST['id'];
        if($id == 1) {
            $stmt = $db->query("SELECT `fg_id`,`fg_name` FROM `fg_data` WHERE `fg_type` = '$id'");
            $stmt->execute();
            $fgs = $stmt->fetchAll();
            echo '<option selected disabled>กรุณาเลือกอาหาร....</option>';
            foreach($fgs as $fg){
                echo '<option value="'.$fg["fg_id"].'">'.$fg["fg_name"].'</option>';
            }
            exit();
        }elseif($id == 2){
            $stmt = $db->query("SELECT `fg_id`,`fg_name` FROM `fg_data` WHERE `fg_type` = '$id'");
            $stmt->execute();
            $fgs = $stmt->fetchAll();
            echo '<option selected disabled>กรุณาเลือกอาหาร....</option>';
            foreach($fgs as $fg){
                echo '<option value="'.$fg["fg_id"].'">'.$fg["fg_name"].'</option>';
            }
            exit();
        }else{
            $stmt = $db->query("SELECT `fg_id`,`fg_name` FROM `fg_data` WHERE `fg_type` = '$id'");
            $stmt->execute();
            $fgs = $stmt->fetchAll();
            echo '<option selected disabled>กรุณาเลือกอาหาร....</option>';
            foreach($fgs as $fg){
                echo '<option value="'.$fg["fg_id"].'">'.$fg["fg_name"].'</option>';
            }
            exit();
        }
    }

?>