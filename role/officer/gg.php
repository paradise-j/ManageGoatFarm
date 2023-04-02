<?php
    require_once 'connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'type'){
        if($_POST['id'] == 1 or $_POST['id'] == 2){
            echo '<option selected disabled>กรุณาเลือกช่วงอายุ....</option>';
            echo '<option value="1">1-2 ปี</option>';
            echo '<option value="2">3-5 ปี</option>';
            echo '<option value="3">5 ปีขึ้นไป</option>';
        }else{
            echo '<option selected disabled>กรุณาเลือกช่วงอายุ....</option>';
            echo '<option value="4">ไม่เกิน 3 เดือน</option>';
            echo '<option value="5">3-4 เดือน</option>';
            echo '<option value="6">4-5 เดือน</option>';
            echo '<option value="7">5 เดือนขึ้นไป</option>';
        }
        exit();
    }
?>