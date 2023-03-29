<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
        header("location: ../../index.php");
        exit;
    }
    require_once 'connect.php';

    if (isset($_REQUEST['edit_id'])) {
        $id = $_REQUEST['edit_id'];
        $select_stmt = $db->prepare("SELECT * FROM `group_farm` WHERE `gf_id` = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
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
            <title>แก้ไขข้อมูลกลุ่มเลี้ยง</title>
            <!-- Custom fonts for this template -->
            <link rel="icon" type="image/png" href="img/seedling-solid.svg" />
            <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link
                href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
                rel="stylesheet">
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
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 text-center">
                                    <h3 class="m-0 font-weight-bold text-primary">แก้ไขข้อมูลกลุ่มเลี้ยง</h3>
                                </div>
                                <div class="card-body">
                                    <form action="Check_edit_vc.php" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <label class="form-label">รหัสกลุ่มเลี้ยง</label>
                                                <input type="text" class="form-control" name="id" style="border-radius: 30px;" value="<?= $gf_id; ?>" readonly required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">ชื่อกลุ่มเลี้ยง</label>
                                                <input type="text" class="form-control" name="name" style="border-radius: 30px;" value="<?= $gf_name; ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="firstname" class="form-label">จังหวัด</label>
                                                <select class="form-control" aria-label="Default select example" id="provinces" name="provinces" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือกจังหวัด....</option>
                                                    <?php 
                                                        $stmt = $db->query("SELECT * FROM `provinces`");
                                                        $stmt->execute();
                                                        $pvs = $stmt->fetchAll();
                                                        
                                                        foreach($pvs as $pv){
                                                    ?>
                                                    <option value="<?= $pv['id']?>"><?= $pv['name_th']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">อำเภอ</label>
                                                <select class="form-control" aria-label="Default select example" id="amphures" name="amphures" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือกอำเภอ....</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ตำบล</label>
                                                <select class="form-control" aria-label="Default select example" id="districts" name="districts" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือกตำบล....</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">รหัสไปรษณีย์</label>
                                                <input type="text" required class="form-control" id="zipcode" name="zipcode" style="border-radius: 30px;">
                                            </div>
                                        <div class="row mt-4">
                                            <div class="col text-center">
                                                <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="submit">บันทึกข้อมูล</button>
                                                &nbsp&nbsp&nbsp
                                                <button class="btn btn-danger" style="border-radius: 30px;" type="submit"">ยกเลิก</button>
                                            </div>
                                        </div>
                                    </form>
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

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            
            <script>
                $('#provinces').change(function(){
                    var id_provnce = $(this).val();
                    $.ajax({
                        type : "post",
                        url : "address.php",
                        data : {id:id_provnce,function:'provinces'},
                        success: function(data){
                            $('#amphures').html(data);
                        }
                    });
                });

                $('#amphures').change(function(){
                    var id_amphures = $(this).val();
                    $.ajax({
                        type : "post",
                        url : "address.php",
                        data : {id:id_amphures,function:'amphures'},
                        success: function(data){
                            $('#districts').html(data);
                        }
                    });
                });

                $('#districts').change(function(){
                    var id_districts = $(this).val();
                    $.ajax({
                        type : "post",
                        url : "address.php",
                        data : {id:id_districts,function:'districts'},
                        success: function(data){
                            $('#zipcode').val(data)
                        }
                    });
                });

            </script>
        </body>

    </html>