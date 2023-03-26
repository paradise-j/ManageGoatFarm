<?php
    require_once 'connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'type'){
        if($_POST['id'] == 1){
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            echo '<option value="สเตรปโตมัยซิน">สเตรปโตมัยซิน</option>';
            echo '<option value="เพนสเตรป">เพนสเตรป</option>';
            echo '<option value="เตตร้าซัยคลิน">เตตร้าซัยคลิน</option>';
            echo '<option value="ยาถ่ายพยาธิ">ยาถ่ายพยาธิ</option>';
            echo '<option value="ยาฆ่าพยาธิภายนอก">ยาฆ่าพยาธิภายนอก</option>';
        }else{
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            echo '<option value="แบลคเลก">แบลคเลก</option>';
            echo '<option value="แอนแทรกซ์">แอนแทรกซ์</option>';
            echo '<option value="โรคปากเท้าเปื่อย">โรคปากเท้าเปื่อย</option>';
        }
        exit();
    }

    // if(isset($_POST['function']) and $_POST['function'] == 'namevm'){
    //     if($_POST['id'] == 1){
    //         echo 'ยาปฏิชีวนะ';
    //     }elseif($_POST['id'] == 2){
    //         echo 'ยาปฏิชีวนะ';
    //     }elseif($_POST['id'] == 3){
    //         echo 'ยาปฏิชีวนะ';
    //     }elseif($_POST['id'] == 4){
    //         echo 'เป็นวัคซีนแบคทีเรียเชื้อตาย
    //         ชนิดตกตะกอนด้วย Potash
    //         alum ชนิดน้้า ผลิตจาก
    //         เชื้อ Clostridium
    //         chauvoei สเตรนท้องถิ่นฆ่า
    //         เชื้อด้วยฟอร์มาลิน วัคซีนมี
    //         ลักษณะเป็นสารแขวนลอย';
    //     }elseif($_POST['id'] == 5){
    //         echo 'ยาปฏิชีวนะ';
    //     }else{
    //         echo 'ยาปฏิชีวนะ';
    //     }
    //     exit();
    // }
?>