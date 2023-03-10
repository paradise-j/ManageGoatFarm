<?php 
    require_once 'connect.php';
    session_start();

    if(isset($_POST["add_sale"])){
         $newid = "SG000";
         $item_array = array(
                'item_agc'           =>     $_POST["agc"],
                'item_cus'           =>     $_POST["cus"],
                'item_gg_type'       =>     $_POST["gg_type"],
                'item_gg_age'        =>     $_POST["gg_age"],
                'item_quantity'      =>     $_POST["quantity"],
                'item_weight'        =>     $_POST["weight"],
                'item_pricekg'         =>     $_POST["pricekg"]
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
    //         echo $key." => ".$value; 
    //         echo "<br>" ;
    //     }
    // }
    

    
    // foreach($_SESSION["shopping_cart"] as $key=>$value){
    //     $sql = "INSERT INTO `sale` (`sale_quantity`, 
    //                                 `sale_weight`, `sale_price`, 
    //                                 `sale_date`, `cus_id`, 
    //                                 `gg_id`, `agc_id`) VALUES ('')";
    //     $conn->execute($sql);
        
    // }
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
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php
        $gg = $db->query("SELECT * FROM `group_g`");
        $gg->execute();
        while($row=mysqli_fetch_array($result)){
    ?>
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
                                    <h3 class="m-0 font-weight-bold text-primary">การขายแพะ</h3>
                                </div>
                                <div class="card-body">
                                    <form action="?" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-2">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อ-สกุล เกษตรกร</label>
                                                <input type="text" class="form-control" id="name" name="agc" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อ-สกุล ผู้ซื้อ</label>
                                                <input type="text" class="form-control" id="Fname" name="cus" style="border-radius: 30px;" required>
                                            </div>
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
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3"></div>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ชื่อ-สกุล เกษตรกร</th>
                                                <th>ชื่อ-สกุล ผู้ซื้อ</th>
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
                                                    <td><?php echo $value['item_agc'];?></td>
                                                    <td><?php echo $value['item_cus'];?></td>
                                                    <td><?php echo $value['item_gg_type'];?></td>
                                                    <td><?php echo $value['item_gg_age'];?></td>
                                                    <td align="right"><?php echo number_format($value['item_quantity'],2);?></td>
                                                    <td align="right"><?php echo number_format($value['item_weight'],2);?></td>
                                                    <td align="right">฿<?php echo number_format($value['item_pricekg'],2);?></td>
                                                    <td align="right">฿<?php echo number_format($value['item_pricekg']*$value['item_weight'],2);?></td>
                                                    <td><a href="add_salegoat.php?action=delete&id=<?php echo $key;?>">ลบสินค้า</td>
                                                </tr>
                                            <?php
                                                $total=$total+($value['item_weight']*$value['item_pricekg']);
                                                }
                                            ?>
                                            <tr>
                                                <td colspan="7" align="right">ราคารวม</td>
                                                <td align="right">฿ <?php echo number_format($total, 2); ?></td>
                                                <td></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <?php echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>'; ?> 
                                    </table>
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