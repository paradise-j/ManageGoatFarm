<?php 
    session_start();
    require_once "connect.php";

    if (isset($_REQUEST['edit_id'])) {
        $id = $_REQUEST['edit_id'];

        $select_stmt = $db->prepare("SELECT * FROM `fm_data` WHERE `fm_id` = :id");
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

    <title>แก้ไขข้อมูลเกษตรกร</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/png" href="img/edit_pro.png" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?><!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('Topbar.php'); ?><!-- Topbar -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 text-center">
                                    <h3 class="m-0 font-weight-bold text-primary">แก้ไขข้อมูลพ่อ-แม่พันธุ์</h3>
                                </div>
                                <div class="card-body">
                                    <form action="Check_edit_Savefm.php" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <label class="form-label">รหัสพ่อ-แม่พันธุ์</label>
                                                <input type="text" class="form-control" name="id" style="border-radius: 30px;" value="<?= $fm_id; ?>" readonly required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ประเภท</label>
                                                <select class="form-control" aria-label="Default select example" name="type" style="border-radius: 30px;" readonly required>
                                                    <option <?php if($fm_type == '1') echo "selected"; ?> value="1">พ่อพันธุ์</option>
                                                    <option <?php if($fm_type == '2') echo "selected"; ?> value="2">แม่พันธุ์</option>

                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อพ่อ-แม่พันธุ์</label>
                                                <input type="text" class="form-control" name="name" style="border-radius: 30px;" value="<?= $fm_name; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">สายพันธุ์</label>
                                                <select class="form-control" aria-label="Default select example" name="breed" style="border-radius: 30px;" readonly required>
                                                    <?php 
                                                        $stmt = $db->query("SELECT * FROM `g_breed`");
                                                        $stmt->execute();
                                                        $gbs = $stmt->fetchAll();
                                                        
                                                        foreach($gbs as $gb){
                                                    ?>
                                                    <option <?php if($gb['gb_id'] == $gb_id) echo "selected"; ?> value="<?= $gb['gb_id']; ?>"><?= $gb['gb_name']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
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
                        <div class="col-lg-1"></div>
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

</body>

</html>