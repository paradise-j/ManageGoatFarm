<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
        header("location: ../../index.php");
        exit;
    }
    require_once 'connect.php';


    if(isset($_POST["add_sale"])){
        $gg_type = $_POST['gg_type'];
        $id_user = $_SESSION["id"];
        $agc = $db->prepare("SELECT `agc_id` FROM `user_login` WHERE `user_id` = '$id_user'");
        $agc->execute();
        $row = $agc->fetch(PDO::FETCH_ASSOC);
        extract($row);


        $gg = $db->prepare("SELECT * FROM `group_g` WHERE `agc_id` = '$agc_id'");
        $gg->execute();
        while ($row = $gg->fetch(PDO::FETCH_ASSOC)) {
            if($gg_type == $row["gg_type"]){
                $gg_id = $row["gg_id"]; 
                break;
            }
        }

        $gg2 = $db->prepare("SELECT * FROM `group_g` WHERE `agc_id` = '$agc_id' AND `gg_id` = '$gg_id'");
        $gg2->execute();
        $row = $gg2->fetch(PDO::FETCH_ASSOC);
        extract($row);

        if($_POST["quantity"] > $gg_quantity){
            $_SESSION['error'] = 'ยอดแพะของท่านไม่เพียงพอ';
            header("refresh:2; url=add_salegoat.php");
        }else{
            $item_array = array(
                // 'item_agc'           =>     $_POST["agc"],
                // 'item_cus'           =>     $_POST["cus"],
                'item_gg_type'       =>     $_POST["gg_type"],
                // 'item_gg_age'        =>     $_POST["gg_age"],
                'item_id_gg'         =>     $gg_id,
                'item_quantity'      =>     $_POST["quantity"],
                'item_weight'        =>     $_POST["weight"],
                'item_pricekg'       =>     $_POST["pricekg"],
                'item_price'         =>     $_POST["pricekg"]*$_POST["weight"]
                );
                $_SESSION["shopping_cart"][] =  $item_array;
            header("location:add_salegoat.php");
            exit;
        }
    }

    if(isset($_GET['action'])){
        if($_GET['action']=="delete"){
            $id = $_GET["id"];
            unset($_SESSION["shopping_cart"][$id]);
            header("location:add_salegoat.php");
            exit;
            $total = $total-($_SESSION["shopping_cart"]['item_weight']*$_SESSION["shopping_cart"]['item_pricekg']);
          }
    }
    
    // echo '<pre>' . print_r($_SESSION["shopping_cart"], TRUE) . '</pre>'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>การขายแพะ</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/png" href="img/edit_pro.png" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?><!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('Topbar.php'); ?><!-- Topbar -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 text-center">
                                    <h5 class="m-0 font-weight-bold text-primary">รายละเอียดการขายแพะ</h5>
                                </div>
                                <div class="card-body">
                                    <form action="?" method="POST" enctype="multipart/form-data">
                                        <?php if(isset($_SESSION['error'])) { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php 
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                ?>
                                            </div>
                                        <?php } ?>
                                        <div class="row mt-2">
                                            <div class="col text-center">
                                                <label style="color:red;" >**** ในกรณีในเดือนนั้นขายแพะไม่ครบทุกประเภท ให้ระบุค่า 0 ลงในประเภทแพะที่ไม่ได้ขาย ****</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-2"></div>
                                            
                                            <div class="col-md-2">
                                                <label class="form-label">ประเภทแพะ</label>
                                                <select class="form-control" aria-label="Default select example"  id="gg_type" name="gg_type" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือก....</option>
                                                    <option value="1">พ่อพันธุ์</option>
                                                    <option value="2">แม่พันธุ์</option>
                                                    <option value="3">แพะขุน</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">จำนวน (ตัว)</label>
                                                <input type="number" class="form-control" id="Gname" name="quantity" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">น้ำหนักรวม (กิโลกรัม)</label>
                                                <input type="number" class="form-control" id="personid" name="weight" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ราคาต่อกิโลกรัม</label>
                                                <input type="number" class="form-control" id="phone" name="pricekg" style="border-radius: 30px;" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-right">
                                                <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="add_sale">เพิ่มรายการ</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="card-header py-3 text-center mb-4">
                                        <h5 class="m-0 font-weight-bold text-primary">รายการขายแพะ</h5>
                                    </div>
                                    <form action="Check_Add_salegoat.php" method="post">
        
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <label class="form-label">ชื่อผู้ซื้อ</label>
                                                <input type="text" class="form-control" name="cus" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" name="phone" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">วันที่ขาย</label>
                                                <?php $date = date('Y-m-d'); ?>
                                                <input type="date" class="form-control" name="date" max="<?= $date; ?>" style="border-radius: 30px;" required>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ประเภทแพะ</th>
                                                        <th>จำนวน</th>
                                                        <th>น้ำหนักรวม</th>
                                                        <th>ราคาต่อกิโลกรัม</th>
                                                        <th>ราคา</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if(!empty($_SESSION["shopping_cart"])){
                                                        $total=0;
                                                        foreach ($_SESSION['shopping_cart'] as $key => $value) { 
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    if($value['item_gg_type'] == 1){
                                                                        echo "พ่อพันธุ์";
                                                                    }elseif($value['item_gg_type'] == 2){
                                                                        echo "แม่พันธุ์";
                                                                    }else{
                                                                        echo "แพะขุน";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td align="right"><?php echo number_format($value['item_quantity'],2);?> ตัว</td>
                                                            <td align="right"><?php echo number_format($value['item_weight'],2);?> กก.</td>
                                                            <td align="right">฿ <?php echo number_format($value['item_pricekg'],2);?> บาท</td>
                                                            <td align="right">฿ <?php echo number_format($value['item_pricekg']*$value['item_weight'],2);?> บาท</td>
                                                            <td><a href="add_salegoat.php?action=delete&id=<?php echo $key;?>">ลบรายการ</td>
                                                        </tr>
                                                    <?php
                                                        $total=$total+($value['item_weight']*$value['item_pricekg']);
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="4" align="right">ราคารวม</td>
                                                        <td align="right">฿ <?php echo number_format($total, 2); ?> บาท</td>
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <!-- <?php echo '<pre>' . print_r($_SESSION["shopping_cart"], TRUE) . '</pre>'; ?>  -->
                                            </table>
                                        </div>
                                        <div class="row mt-4 mb-4">
                                            <div class="col text-right">
                                                <!-- <a href="add_salegoat.php?type=submit" class="btn btn-blue" style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</a> -->
                                                <button class="btn btn-blue " style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</button>
                                            </div>  
                                        </div>
                                    </form>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.php'); ?><!-- Footer -->
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $('#gg_type').change(function(){
            var id_gg_type = $(this).val();
            $.ajax({
                type : "post",
                url : "gg2.php",
                data : {id:id_gg_type,function:'gg_type'},
                success: function(data){
                    $('#gg_age').html(data);
                }
            });
        });

        


        // doucument.getElemetById('save_saleall').onclick = function(){save_saleall()} ;

        // function save_saleall() {

        $(document).ready(function() {
            $('#save_saleall').click(function(){
                Swal.fire({
                    title: 'บันทึกข้อมูลสำเร็จ',
                    text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                    icon: 'success',
                    timer: 5000,
                    showConfirmButton: false
                });
            });
        });   
        // }
       
        
    </script>

</body>

</html>