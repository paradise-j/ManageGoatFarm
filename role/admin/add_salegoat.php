<?php 
    require_once 'connect.php';
    session_start();

    if(isset($_POST["add_sale"])){
        $gg_type = $_POST['gg_type'];
        $gg_age = $_POST['gg_age'];

        $gg = $db->prepare("SELECT * FROM `group_g`");
        $gg->execute();
        while ($row = $gg->fetch(PDO::FETCH_ASSOC)) {
            if($gg_type == $row["gg_type"] and $gg_age == $row["gg_range_age"]){
                $gg_id = $row["gg_id"]; 
                break;
            }
        }
        $item_array = array(
            // 'item_agc'           =>     $_POST["agc"],
            // 'item_cus'           =>     $_POST["cus"],
            'item_gg_type'       =>     $_POST["gg_type"],
            'item_gg_age'        =>     $_POST["gg_age"],
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

    if(isset($_GET['action'])){
        if($_GET['action']=="delete"){
            $id = $_GET["id"];
            unset($_SESSION["shopping_cart"][$id]);
            header("location:add_salegoat.php");
            exit;
            $total = $total-($_SESSION["shopping_cart"]['item_weight']*$_SESSION["shopping_cart"]['item_pricekg']);
          }
    }

    
    // for($i=0; $i<count($_SESSION["shopping_cart"]); $i++){
    //     foreach($_SESSION["shopping_cart"][$i] as $key=>$value){
    //         echo $key." ==> ".$value;
    //         echo "<br>";
    //     }
    //     echo "<----------------------------------------->";
    //     echo "<br>";
        
    // }
    
    // echo '<pre>' . print_r($_SESSION["shopping_cart"], TRUE) . '</pre>'; 
    if(isset($_GET['type'])){
        if($_GET['type'] == "submit"){
            foreach($_SESSION["shopping_cart"] as $key=>$value){
                $quantity = $value["item_quantity"];
                $weight = $value["item_weight"];
                $pricekg = $value["item_pricekg"];
                $price = $value["item_price"];
                $sql = $db->prepare("INSERT INTO `salelist` (`slist_quantity`, `slist_weight`, `slist_KgPirce`, `slist_price`, `sale_id`) 
                                 VALUES ($quantity, $weight, $pricekg, $price,'')");
                $sql->execute();
                 
            }
            unset($_SESSION["shopping_cart"]);
            header("location:add_salegoat.php");
        }
    }

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
    <link href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

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
                                        <div class="row mb-2">
                                            <div class="col-md-1"></div>
                                            <!-- <div class="col-md-3">
                                                <label class="form-label">ชื่อ-สกุล เกษตรกร</label>
                                                <input type="text" class="form-control" id="name" name="agc" style="border-radius: 30px;" value="นายสมรัก อึอิ" required>
                                            </div> -->
                                            <!-- <div class="col-md-3">
                                                <label class="form-label">ชื่อ-สกุล ผู้ซื้อ</label>
                                                <input type="text" class="form-control" id="Fname" name="cus" style="border-radius: 30px;" value="นายสมยศ คูคู" required>
                                            </div> -->
                                            <div class="col-md-2">
                                                <label class="form-label">ประเภทแพะ</label>
                                                <select class="form-control" aria-label="Default select example"  name="gg_type" style="border-radius: 30px;" required>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">แพะพ่อพันธุ์</option>
                                                    <option value="2">แพะแม่พันธุ์</option>
                                                    <option value="3">แพะขุน</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ช่วงอายุ</label>
                                                <select class="form-control" aria-label="Default select example"  name="gg_age" style="border-radius: 30px;" required>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">1-2 ปี</option>
                                                    <option value="2">3-5 ปี</option>
                                                    <option value="3">5 ปีขึ้นไป</option>
                                                    <option value="4">ไม่เกิน 4 เดือน</option>
                                                    <option value="5">ไม่เกิน 5 เดือน</option>
                                                    <option value="6">ไม่เกิน 6 เดือน</option>
                                                    <option value="7">6 เดือนขึ้นไป</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">จำนวน</label>
                                                <input type="text" class="form-control" id="Gname" name="quantity" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">น้ำหนักรวม</label>
                                                <input type="text" class="form-control" id="personid" name="weight" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ราคาต่อกิโลกรัม</label>
                                                <input type="text" class="form-control" id="phone" name="pricekg" style="border-radius: 30px;" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3"></div>
                                            <!-- <div class="col-md-2">
                                                <label class="form-label">จำนวน</label>
                                                <input type="text" class="form-control" id="Gname" name="quantity" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">น้ำหนักรวม</label>
                                                <input type="text" class="form-control" id="personid" name="weight" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ราคาต่อกิโลกรัม</label>
                                                <input type="text" class="form-control" id="phone" name="pricekg" style="border-radius: 30px;" required>
                                            </div> -->
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <!-- <th>ชื่อ-สกุล เกษตรกร</th> -->
                                                    <!-- <th>ชื่อ-สกุล ผู้ซื้อ</th> -->
                                                    <th>ประเภทแพะ</th>
                                                    <th>ช่วงอายุแพะ</th>
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
                                                        <!-- <td><?php echo $value['item_agc'];?></td> -->
                                                        <!-- <td><?php echo $value['item_cus'];?></td> -->
                                                        <td>
                                                            <?php
                                                                if($value['item_gg_type'] == 1){
                                                                    echo "แพะพ่อพันธุ์";
                                                                }elseif($value['item_gg_type'] == 1){
                                                                    echo "แพะแม่พันธุ์";
                                                                }else{
                                                                    echo "แพะขุน";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($value['item_gg_age'] == 1){
                                                                    echo "1-2 ปี";
                                                                }elseif($value['item_gg_age'] == 2){
                                                                    echo "3-5 ปี";
                                                                }elseif($value['item_gg_age'] == 3){
                                                                    echo "5 ปีขึ้นไป";
                                                                }elseif($value['item_gg_age'] == 4){
                                                                    echo "ไม่เกิน 4 เดือน";
                                                                }elseif($value['item_gg_age'] == 5){
                                                                    echo "ไม่เกิน 5 เดือน";
                                                                }elseif($value['item_gg_age'] == 6){
                                                                    echo "ไม่เกิน 6 เดือน";
                                                                }else{
                                                                    echo "6 เดือนขึ้นไป";
                                                                }
                                                            
                                                            ?>
                                                        </td>
                                                        <td align="right"><?php echo number_format($value['item_quantity'],2);?> ตัว</td>
                                                        <td align="right"><?php echo number_format($value['item_weight'],2);?> กก.</td>
                                                        <td align="right">฿ <?php echo number_format($value['item_pricekg'],2);?> บาท</td>
                                                        <td align="right">฿ <?php echo number_format($value['item_pricekg']*$value['item_weight'],2);?> บาท</td>
                                                        <td><a href="add_salegoat.php?action=delete&id=<?php echo $key;?>">ลบสินค้า</td>
                                                    </tr>
                                                <?php
                                                    $total=$total+($value['item_weight']*$value['item_pricekg']);
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="5" align="right">ราคารวม</td>
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
                                    <div class="row mt-4">
                                        <div class="col text-right">
                                            <a href="add_salegoat.php?type=submit" class="btn btn-blue" style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</a>
                                            <!-- <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</button> -->
                                        </div>
                                    </div>
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
    
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }

</body>

</html>