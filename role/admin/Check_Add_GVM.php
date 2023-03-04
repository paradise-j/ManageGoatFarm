<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $Gtype = $_POST['Gtype'];
        $range_age = $_POST['range_age'];
        $VMtype = $_POST['VMtype'];
        $VMname = $_POST['VMname'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $month = $_POST['month'];


        $VM = $db->prepare("SELECT * FROM `group_g`");
        $VM->execute();

        while ($Gtype == $VM["gg_type"] and $range_age == $VM["gg_range_age"]) {
            $gg_id = $VM["gg_id"];
        }


        $sql = $db->prepare("INSERT INTO `gvc_data`(`gvc_type`, `gvc_quantity`, `gvc_price`, `gvc_month`, `gg_id`, `vc_id`) 
                                            VALUES ('$VMtype','$quantity','$price','$month','$gg_id','$VMname')");
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
            header("refresh:2; url=Manage_vm.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Manage_vm.php");
        }
    }
?>