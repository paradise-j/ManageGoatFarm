<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
        header("location: ../../index.php");
        exit;
    }
    require_once 'connect.php';

    if (isset($_REQUEST['edit_id'])) {
        $id = $_REQUEST['edit_id'];
        $select_stmt = $db->prepare("SELECT * FROM `vc_data` WHERE `vc_id` = :id");
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
            <title>แก้ไขข้อมูลกลุ่มแพะ</title>
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
                                    <h3 class="m-0 font-weight-bold text-primary">แก้ไขข้อมูลยาและวัคซีน</h3>
                                </div>
                                <div class="card-body">
                                    <form action="Check_edit_vc.php" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <label class="form-label">รหัสยาและวัคซีน</label>
                                                <input type="text" class="form-control" name="id" style="border-radius: 30px;" value="<?= $vc_id; ?>" readonly required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ประเภท</label>
                                                <select class="form-control" aria-label="Default select example" name="type" style="border-radius: 30px;" required>
                                                    <option <?php if($vc_type == '1') echo "selected"; ?> value="1">ยา</option>
                                                    <option <?php if($vc_type == '2') echo "selected"; ?> value="2">วัคซีน</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อ</label>
                                                <input type="text" class="form-control" name="name" style="border-radius: 30px;" value="<?= $vc_name; ?>" required>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">รายละเอียด</label>
                                                <input type="text" class="form-control" name="descrip" style="border-radius: 30px;" value="<?= $vc_descrip; ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
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

        </body>

    </html>