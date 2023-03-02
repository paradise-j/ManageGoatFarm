<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $type = $_POST['type'];
        $range_age = $_POST['range_age'];
        $amount = $_POST['amount'];
        $priceKG = $_POST['priceKG'];
        $month = $_POST['month'];
        $sql = $db->prepare("INSERT INTO `gfg_data`(`gfg_type`, `gfg_range_age`, `gfg_quantity`, `gfg_price`, `gfg_month`) 
                             VALUES ('$type','$range_age','$amount','$priceKG','$month')");
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
            header("refresh:2; url=Save_feeding.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Save_feeding.php");
        }
    }
?>