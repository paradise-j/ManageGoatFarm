<?php
    require_once 'connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'typemoney'){
        if($_POST['id'] == 1){
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            echo '<option value="ขายมูลแพะ">ขายมูลแพะ</option>';
        }elseif($_POST['id'] == 2){
            $stmt = $db->query("SELECT * FROM `fg_data`");
            $stmt->execute();
            $fgs = $stmt->fetchAll();
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            foreach($fgs as $fg){
                echo '<option value="'.$fg['fg_name'].'">'.$fg["fg_name"].'</option>';
            }
        }else{
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            echo '<option value="ค่าน้ำมันตัดหญ้า">ค่าน้ำมันตัดหญ้า</option>';
            echo '<option value="ค่าปุ๋ย">ค่าปุ๋ย</option>';
        }
        exit();
    }
?>