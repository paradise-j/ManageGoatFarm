<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $FB = $_POST['FB'];
        $MB = $_POST['MB'];
        $quantity = $_POST['quantity'];
        $g_male = $_POST['g_male'];
        $g_female = $_POST['g_female'];
        $sql = $db->prepare("INSERT INTO `nbg_data`(`nbg_Fg`, `nbg_Mg`, `nbg_quantity`, `nbg_male`, `nbg_female`)
                             VALUES ('$FB','$MB','$quantity','$g_male','$g_female')");
        $sql->execute();

        if ($sql) {
            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'success',
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