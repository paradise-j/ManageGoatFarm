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

    <title>ประวัติส่วนตัว</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/png" href="img/edit_pro.png" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
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
                                    <h3 class="m-0 font-weight-bold text-primary">ประวัติส่วนตัว</h3>
                                </div>
                                <div class="card-body">
                                    <form ction="" method="POST">
                                        <div class="row mb-4">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-1 text-center">
                                                <img loading="lazy" width="175px" style="border-radius: 200px;" src="uploads/494225.jpg" id="previewImg" alt="">
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3">
                                                <label for="validationDefault01" class="form-label">อัปโหลดรูปภาพ</label>
                                                <input type="file" class="form-control" id="imgInput" style="border-radius: 30px;" name="img" required disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-2">
                                                <label for="validationDefault01" class="form-label">รหัสเกษตรกร</label>
                                                <input type="text" class="form-control" id="idAgc" style="border-radius: 30px;" required disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" id="name" style="border-radius: 30px;" required disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อฟาร์ม</label>
                                                <input type="text" class="form-control" id="Fname" style="border-radius: 30px;" required disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ตำแหน่ง</label>
                                                <select class="form-control" aria-label="Default select example" id="position" style="border-radius: 30px;" required disabled>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">ประธาน</option>
                                                    <option value="2">รองประธาน</option>
                                                    <option value="3">เลขานุการ</option>
                                                    <option value="4">สมาชิก</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label">ชื่อกลุ่มเลี้ยง</label>
                                                <input type="text" class="form-control" id="Gname" style="border-radius: 30px;" required disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">เลขประจำตัวประชาชน</label>
                                                <input type="text" class="form-control" id="personid" style="border-radius: 30px;" required disabled>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" id="phone" style="border-radius: 30px;" required disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">ระดับการศึกษา</label>
                                                <select class="form-control" aria-label="Default select example" id="edu" style="border-radius: 30px;" required disabled>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">ประถมศึกษา</option>
                                                    <option value="2">มัธยมศึกษา</option>
                                                    <option value="3">ปวช.</option>
                                                    <option value="4">ปวส.</option>
                                                    <option value="5">ปริญาตรี</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">ประสบการณ์เลี้ยง</label>
                                                <select class="form-control" aria-label="Default select example" id="exper" style="border-radius: 30px;" required disabled>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">1-2 ปี</option>
                                                    <option value="2">3-5 ปี</option>
                                                    <option value="3">5 ปีขึ้นไป</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">จุดประสงค์เลี้ยง</label>
                                                <select class="form-control" aria-label="Default select example" id="obj" style="border-radius: 30px;" required disabled>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">เพื่อขุนขาย</option>
                                                    <option value="2">เพื่อขายพ่อ-แม่พันธุ์</option>
                                                    <option value="3">เพื่อขุนขายและขายพ่อ-แม่พันธุ์</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">ประเภทลี้ยง</label>
                                                <select class="form-control" aria-label="Default select example" id="type" style="border-radius: 30px;" required disabled>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <option value="1">แบบยืนโรง</option>
                                                    <option value="2">แบบกึ่ง</option>
                                                    <option value="3">แบบธรรมชาติ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <button class="btn btn-warning" style="border-radius: 30px;" type="submit" onclick="enable()">แก้ไขข้อมูล</button>
                                                &nbsp&nbsp&nbsp
                                                <button class="btn btn-blue" style="border-radius: 30px;" type="submit">บันทึกข้อมูล</button>
                                                &nbsp&nbsp&nbsp
                                                <button class="btn btn-danger" style="border-radius: 30px;" type="submit" onclick="disable()">ยกเลิกการแก้ไข</button>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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