<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $agc = $_POST['agc'];
        $cus = $_POST['cus'];
        $gg_type = $_POST['gg_type'];
        $gg_age = $_POST['gg_age'];
        $quantity = $_POST['quantity'];
        $weight = $_POST['weight'];
        $pricekg = $_POST['pricekg'];
        $sumprice = $_POST['weight'] * $_POST['pricekg'];
        $date = $_POST['date'];


        // ===================== Check id G_Goat =====================
        $gg = $db->prepare("SELECT * FROM `group_g`");
        $gg->execute();
        while ($row = $gg->fetch(PDO::FETCH_ASSOC)) {
            if($gg_type == $row["gg_type"] and $gg_age == $row["gg_range_age"]){
                $gg_id = $row["gg_id"]; 
                break;
            }
        }

        // ===================== Check id agriculturist =====================
        $agc = $db->prepare("SELECT * FROM `agriculturist`");
        $agc->execute();
        while ($row = $agc->fetch(PDO::FETCH_ASSOC)) {
            if($agc == $row["gg_name"]){
                $agc_id = $row["agc_id"]; 
                break;
            }
        }

        // ===================== Check id Customer =====================
        $cus = $db->prepare("SELECT * FROM `customer`");
        $cus->execute();
        while ($row = $cus->fetch(PDO::FETCH_ASSOC)) {
            if($cus == $row["cus_name"]){
                $cus_id = $row["gg_id"]; 
                break;
            }
        }




        $sql = $db->prepare("INSERT INTO `sale`(`sale_quantity`, `sale_weight`, `sale_price`, `sale_date`, `cus_id`, `gg_id`, `agc_id`)
                                            VALUES ('$quantity','$weight','$sumprice','$date','$cus_id','$gg_id','$agc_id')");
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
            header("refresh:1; url=SaleListGoat.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: SaleListGoat.php");
        }
    }
    $db = null; 
?>