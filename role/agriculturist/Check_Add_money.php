<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";


    $id = $_SESSION['id'];
    $check_id = $db->prepare("SELECT agriculturist.agc_id
                                FROM `user_login` 
                                INNER JOIN `agriculturist` ON user_login.agc_id = agriculturist.agc_id
                                WHERE user_login.user_id = '$id'");
    $check_id->execute();
    $row = $check_id->fetch(PDO::FETCH_ASSOC);
    $agc_id = $row["agc_id"];


    if (isset($_POST['submit'])) {
        $type = $_POST['typemoney'];
        $list = $_POST['list'];
        $quan = $_POST['quan'];
        $date = $_POST['date'];
        $sql = $db->prepare("INSERT INTO `money_inex`(`money_type`, `money_list`, `money_quan`, `money_date`, `agc_id`) VALUES 
                                                    ('$type','$list','$quan','$date','$agc_id')");
        $sql->execute();

        if ($sql) {
            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=Save_money.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Save_money.php");
        }
    }
?>