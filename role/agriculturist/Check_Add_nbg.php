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
    $agc_id = $row["agc_id"] ;

    if (isset($_POST['submit'])) {
        $FB = $_POST['FB'];
        $MB = $_POST['MB'];
        $g_male = $_POST['g_male'];
        $g_female = $_POST['g_female'];
        $quantity = $g_male + $g_female;
        $date = $_POST['date'];


        $sql = $db->prepare("INSERT INTO `nbg_data`(`nbg_quantity`, `nbg_male`, `nbg_female`, `nbg_date`, `F_id`, `M_id`, `agc_id`)
                             VALUES ($quantity, $g_male, $g_female, '$date', '$FB', '$MB', '$agc_id')");
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
            header("refresh:1; url=Save_NBgoat.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Save_NBgoat.php");
        }
    }
?>