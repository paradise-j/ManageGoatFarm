<?php 
    require_once 'connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>บันทึกข้อมูลการให้อาหาร</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/png" href="img/seedling-solid.svg" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
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
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="card shadow mb-2">
                                <div class="card-header py-3 text-center">
                                    <h3 class="m-0 font-weight-bold text-primary">บันทึกข้อมูลการให้อาหาร</h3>
                                </div>
                                <div class="card-body">
                                    <!-- <div class="row mb-2">
                                        <div class="col text-center">
                                            <img loading="lazy" width="75px" style="border-radius: 200px;" src="img/Goat.png" alt="">
                                        </div>
                                    </div> -->
                                    <form action="Chack_Add_agc.php" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label">ประเภท</label>
                                                <select class="form-control" aria-label="Default select example" id="position" name="position" style="border-radius: 30px;" required>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">แพะพ่อพันธุ์</option>
                                                    <option value="2">แพะแม่พันธุ์</option>
                                                    <option value="3">แพะขุน</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ช่วงอายุ</label>
                                                <select class="form-control" aria-label="Default select example" id="position" name="position" style="border-radius: 30px;" required>
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
                                                <label class="form-label">ปริมาณอาหาร</label>
                                                <input type="text" class="form-control" id="Fname" name="Fname" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ราคาต่อกิโลกรัม</label>
                                                <input type="text" class="form-control" id="Gname" name="Gname" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="inputState" class="form-label">เดือนที่ให้อาหาร</label>
                                                <select class="form-control" aria-label="Default select example" id="edu" name="edu" style="border-radius: 30px;" required>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">มกราคม</option>
                                                    <option value="2">กุมภาพันธ์</option>
                                                    <option value="3">มีนาคม</option>
                                                    <option value="4">เมษายน</option>
                                                    <option value="5">พฤษภาคม</option>
                                                    <option value="6">มิถุนายน</option>
                                                    <option value="7">กรกฎาคม</option>
                                                    <option value="8">สิงหาคม</option>
                                                    <option value="9">กันยายน</option>
                                                    <option value="10">ตุลาคม</option>
                                                    <option value="11">พฤศจิกายน</option>
                                                    <option value="12">ธันวาคม</option>
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
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>รหัสการให้อาหาร</th>
                                            <th>ประเภท</th>
                                            <th>ช่วงอายุ</th>
                                            <th>ปริมาณอาหาร</th>
                                            <th>ราคา</th>
                                            <th>เดือนที่ให้</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `agriculturist`");
                                            $stmt->execute();
                                            $agcs = $stmt->fetchAll();

                                            if (!$agcs) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($agcs as $agc)  {  
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $agc['agc_id']; ?></th>
                                            <td><?= $agc['agc_name']; ?></td>
                                            <td><?= $agc['agc_nfarm']; ?></td>
                                            <td><?= $agc['agc_position_G']; ?></td>
                                            <td><?= $agc['agc_gfarm']; ?></td>
                                            <td><?= $agc['agc_phone']; ?></td>
                                            <td><a href="Edit_agc.php?edit_id=<?= $agc['agc_id']; ?>" class="btn btn-warning" name="edit_id">Edit</a></td>
                                            <td><a data-id="<?= $agc['agc_id']; ?>" href="?delete=<?= $agc['agc_id']; ?>" class="btn btn-danger delete-btn">Delete</a></td>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

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
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }
        function enable() {
            document.getElementById("idAgc").disabled = false;
            document.getElementById("name").disabled = false;
            document.getElementById("Fname").disabled = false;
            document.getElementById("position").disabled = false;
            document.getElementById("Gname").disabled = false;
            document.getElementById("personid").disabled = false;
            document.getElementById("phone").disabled = false;
            document.getElementById("edu").disabled = false;
            document.getElementById("exper").disabled = false;
            document.getElementById("obj").disabled = false;
            document.getElementById("type").disabled = false;
            document.getElementById("imgInput").disabled = false;
        }
        function disable() {
            document.getElementById("idAgc").disabled = true;
            document.getElementById("name").disabled = true;
            document.getElementById("Fname").disabled = true;
            document.getElementById("position").disabled = true;
            document.getElementById("Gname").disabled = true;
            document.getElementById("personid").disabled = true;
            document.getElementById("phone").disabled = true;
            document.getElementById("edu").disabled = true;
            document.getElementById("exper").disabled = true;
            document.getElementById("obj").disabled = true;
            document.getElementById("type").disabled = true;
            document.getElementById("imgInput").disabled = true;
        }
    </script>

</body>

</html>