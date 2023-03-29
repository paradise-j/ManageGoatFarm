<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $range_age = $_POST['range_age'];
        $quantity = $_POST['quantity'];
        // echo $id."<br>";
        // echo $type."<br>";
        // echo $range_age."<br>";
        // echo $quantity;
        $sql = $db->prepare("UPDATE `group_g` SET `gg_quantity`= $quantity WHERE `gg_id` = '$id' ");
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
            header("refresh:1; url=Manage_Ggoat.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Manage_Ggoat.php");
        }
    }
?>