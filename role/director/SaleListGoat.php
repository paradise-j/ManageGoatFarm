<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
        header("location: ../../index.php");
        exit;
    }
    require_once 'connect.php';

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `agriculturist` WHERE `agc_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Manage_agc.php");
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

        <!-- Custom fonts for this template -->
        <link rel="icon" type="image/png" href="img/edit_pro.png" />
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    </head>

    <body id="page-top">
        <?php
            $agc = $db->query("SELECT * FROM `agriculturist` WHERE `agc_id`= 'AG0001'");
            $agc->execute();
            $row = $agc->fetch(PDO::FETCH_ASSOC);
            extract($row);
        ?>
        <div id="wrapper">
            <?php include('sidebar.php'); ?><!-- Sidebar -->
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include('Topbar.php'); ?><!-- Topbar -->
                    <div class="container-fluid">
                        <!-- DataTales Example -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 text-center">
                                        <h3 class="m-0 font-weight-bold text-primary">การขายแพะ</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="Check_Add_salegoat.php" method="POST">
                                            <div class="row mb-2">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-3">
                                                    <label class="form-label">ชื่อ-สกุล การขายแพะ</label>
                                                    <input type="text" class="form-control" name="agc" style="border-radius: 30px;" value="<?= $agc_name ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">ชื่อ-สกุล ผู้ซื้อ</label>
                                                    <input type="text" class="form-control" name="cus" style="border-radius: 30px;" value="นายประเทือง ทมทม" required>
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
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2">
                                                    <label class="form-label">จำนวน</label>
                                                    <input type="text" class="form-control" name="quantity" style="border-radius: 30px;" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">น้ำหนักรวม</label>
                                                    <input type="text" class="form-control" name="weight" style="border-radius: 30px;" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">ราคาต่อกิโลกรัม</label>
                                                    <input type="text" class="form-control" name="pricekg" style="border-radius: 30px;" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="inputState" class="form-label">วันที่ทำการขาย</label>
                                                    <input type="date" style="border-radius: 30px;" name="date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-right">
                                                    <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="submit">เพิ่มรายการ</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <!-- <div class="card-header py-3 text-center">
                                <h3 class="m-0 font-weight-normal text-primary">รายการขายแพะ</h3>
                            </div> -->
                            <div class="row mt-4 ml-2">
                                <div class="col">
                                    <a href="add_salegoat.php" class="btn btn-blue" style="border-radius: 30px;" type="submit">เพิ่มการขายแพะ</a>
                                    <!-- <button class="btn btn-blue" style="border-radius: 30px;" type="submit">เพิ่มการขายแพะ</button> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr align="center">
                                                <th>รหัสการขายแพะ</th>
                                                <th>ชื่อ-สกุล ผู้ซื้อ</th>
                                                <th>ประเภทแพะ</th>
                                                <th>ช่วงอายุแพะ</th>
                                                <th>จำนวนแพะ</th>
                                                <th>น้ำหนักรวม</th>
                                                <th>ราคาต่อกิโลกรัม</th>
                                                <th>ราคารวม</th>
                                                <th>วันที่ทำการขาย</th>
                                                <!-- <th></th> -->
                                                <!-- <th></th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $stmt = $db->query("SELECT sale.sale_id , agriculturist.agc_name , customer.cus_name , group_g.gg_type , group_g.gg_range_age , sale.sale_quantity , sale.sale_weight ,sale.sale_KgPirce , sale.sale_price , sale.sale_date
                                                                    FROM sale
                                                                    INNER JOIN agriculturist ON agriculturist.agc_id = sale.agc_id
                                                                    INNER JOIN customer ON customer.cus_id = sale.cus_id
                                                                    INNER JOIN group_g ON group_g.gg_id = sale.gg_id");
                                                $stmt->execute();
                                                $sales = $stmt->fetchAll();

                                                if (!$sales) {
                                                    echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                                } else {
                                                foreach($sales as $sale)  {  
                                            ?>
                                            <tr align="center">
                                                <th scope="row"><?= $sale['sale_id']; ?></th>
                                                <!-- <td><?= $sale['agc_name']; ?></td> -->
                                                <td><?= $sale['cus_name']; ?></td>
                                                <td>
                                                    <?php 
                                                        if($sale['gg_type'] == 1){
                                                            echo "แพะพ่อพันธุ์";
                                                        }elseif($sale['gg_type'] == 2) {
                                                            echo "แพะแม่พันธุ์";
                                                        }else{
                                                            echo "แพะขุน";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if($sale['gg_range_age'] == 1 ) {
                                                            echo "1-2 ปี";
                                                        }elseif($sale['gg_range_age'] == 2 ) {
                                                            echo "3-5 ปี";
                                                        }elseif($sale['gg_range_age'] == 3 ) {
                                                            echo "5 ปีขึ้นไป";
                                                        }elseif($sale['gg_range_age'] == 4 ) {
                                                            echo "ไม่เกิน 4 เดือน";
                                                        }elseif($sale['gg_range_age'] == 5 ) {
                                                            echo "ไม่เกิน 5 เดือน";
                                                        }elseif($sale['gg_range_age'] == 6 ) {
                                                            echo "ไม่เกิน 6 เดือน";
                                                        }else{
                                                            echo "6 เดือนขึ้นไป";
                                                        }
                                                    ?>
                                                </td>
                                                <td align="right"><?= number_format($sale['sale_quantity'],2); ?> ตัว</td>
                                                <td align="right"><?= number_format($sale['sale_weight'],2); ?> กก.</td>
                                                <td align="right"><?= number_format($sale['sale_KgPirce'],2); ?> บาท</td>
                                                <td align="right">฿ <?= number_format($sale['sale_price'],2); ?> บาท</td>
                                                <td class="date_th"><?= $sale['sale_date']; ?></td>
                                                <!-- <td><a href="Edit_sale.php?edit_id=<?= $sale['sale_id']; ?>" class="btn btn-warning" name="edit_id">Edit</a></td> -->
                                                <!-- <td><a data-id="<?= $sale['sale_id']; ?>" href="?delete=<?= $sale['sale_id']; ?>" class="btn btn-danger delete-btn">Delete</a></td> -->
                                            </tr>
                                            <?php }  
                                                } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('footer.php'); ?><!-- Footer -->
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/sb-admin-2.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="js/demo/datatables-demo.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(".delete-btn").click(function(e) {
                var userId = $(this).data('id');
                e.preventDefault();
                deleteConfirm(userId);
            })

            function deleteConfirm(userId) {
                Swal.fire({
                    title: 'ลบข้อมูล',
                    text: "คุณแน่ใจใช่หรือไม่ที่จบลบข้อมูลนี้",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ลบข้อมูล',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $.ajax({
                                    url: 'Manage_agc.php',
                                    type: 'GET',
                                    data: 'delete=' + userId,
                                })
                                .done(function() {
                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                        icon: 'success',
                                    }).then(() => {
                                        document.location.href = 'Manage_agc.php';
                                    })
                                })
                                .fail(function() {
                                    Swal.fire({
                                        title: 'ไม่สำเร็จ',
                                        text: 'ลบข้อมูลไม่สำเร็จ',
                                        icon: 'danger',
                                    })
                                    window.location.reload();
                                });
                        });
                    },
                });
            }

            const dom_date = document.querySelectorAll('.date_th')
            dom_date.forEach((elem)=>{
                const my_date = elem.textContent
                const date = new Date(my_date)

                const result = date.toLocaleDateString('th-TH', {

                year: 'numeric',

                month: 'long',

                day: 'numeric',

                }) 
                elem.textContent=result
            })
        </script>
    </body>
</html>