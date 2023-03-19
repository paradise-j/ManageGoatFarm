<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $namegf = $_POST['namegf'];
        $provinces = $_POST['provinces'];
        $amphures = $_POST['amphures'];
        $districts = $_POST['districts'];
        $zipcode = $_POST['zipcode'];
        $sql = $db->prepare("INSERT INTO `group_farm`(`gf_name`, `gf_subdis`, `gf_dis`, `gf_province`, `gf_zipcode`)
                             VALUES ('$namegf','$districts','$amphures','$provinces','$zipcode')");
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
            header("refresh:1; url=Manage_Gfarm.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Manage_Gfarm.php");
        }
    }
?>