<?php
    require_once 'connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'type'){
        if($_POST['id'] == 1){
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            echo '<option value="1">ขายมูลแพะ</option>';
        }elseif($_POST['id'] == 2){
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            echo '<option value="1">ค่ายา</option>';
            echo '<option value="2">ค่าวัคซีน</option>';
            echo '<option value="3">ค่าอาหารเสริม</option>';
        }else{
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            echo '<option value="1">ค่าน้ำมันตัดหญ้า</option>';
            echo '<option value="2">ค่าปุ๋ย</option>';
        }
        exit();
    }
?>