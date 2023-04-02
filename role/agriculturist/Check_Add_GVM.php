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
    // echo $agc_id;

    if (isset($_POST['submit'])) {
        $Gtype = $_POST['type'];
        // $range_age = $_POST['range_age'];
        $VMtype = $_POST['VMtype'];
        $vc_id = $_POST['VMname'];
        $quantity = $_POST['quantity'];
        $date = $_POST['date'];


        $VM = $db->prepare("SELECT * FROM `group_g` WHERE `agc_id` = '$agc_id'");
        $VM->execute();

        

        while ($row = $VM->fetch(PDO::FETCH_ASSOC)) {
            if($Gtype == $row["gg_type"]){
                $gg_id = $row["gg_id"]; 
                break;
            }
        }
        // echo $gg_id;


        $sql = $db->prepare("INSERT INTO `gvc_data`(`gvc_type`, `gvc_quantity`, `gvc_date`, `gg_id`, `vc_id`) VALUES 
                            ('$VMtype','$quantity','$date','$gg_id','$vc_id')");
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
            header("refresh:1; url=Save_GVM.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Save_GVM.php");
        }
    }
    $db = null; 
?>