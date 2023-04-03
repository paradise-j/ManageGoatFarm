<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
        header("location: ../../index.php");
        exit;
    }
    require_once 'connect.php';

    if (isset($_REQUEST['edit_id'])) {
        $id = $_REQUEST['edit_id'];

        $select_stmt = $db->prepare("SELECT * FROM `agriculturist` WHERE `agc_id` = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $check_farm = $db->prepare("SELECT `gf_name` FROM `group_farm` WHERE `gf_id` = '$gf_id'");
        $check_farm->execute();
        $row = $check_farm->fetch(PDO::FETCH_ASSOC);
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
                                    <h3 class="m-0 font-weight-bold text-primary">แก้ไขข้อมูลเกษตรกร</h3>
                                </div>
                                <div class="card-body">
                                    <form action="Chack_edit_agc.php" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-4">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-1 text-center">
                                                <img loading="lazy" width="175px" style="border-radius: 200px;" id="previewImg" src="uploads/<?= $agc_img; ?>" alt="">
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3">
                                                <label for="img" class="form-label">อัปโหลดรูปภาพ</label>
                                                <input type="file" class="form-control" id="imgInput" style="border-radius: 30px;" name="img" value="<?= $agc_img; ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-2">
                                                <label class="form-label">รหัสเกษตรกร</label>
                                                <input type="text" class="form-control" id="id" name="id" style="border-radius: 30px;" value="<?= $agc_id; ?>" readonly required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" id="name" name="name" style="border-radius: 30px;" value="<?= $agc_name; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อฟาร์ม</label>
                                                <input type="text" class="form-control" id="Fname" name="Fname" style="border-radius: 30px;" value="<?= $agc_nfarm; ?>" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ตำแหน่ง</label>
                                                <select class="form-control" aria-label="Default select example" id="position" name="position" style="border-radius: 30px;" required>
                                                    <option <?php if($agc_position_G == '1') echo "selected"; ?> value="1">ประธาน</option>
                                                    <option <?php if($agc_position_G == '2') echo "selected"; ?> value="2">รองประธาน</option>
                                                    <option <?php if($agc_position_G == '3') echo "selected"; ?> value="3">เลขานุการ</option>
                                                    <option <?php if($agc_position_G == '4') echo "selected"; ?> value="4">สมาชิก</option>
                                                    <option <?php if($agc_position_G == '5') echo "selected"; ?> value="5">การตลาด</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label">ชื่อกลุ่มเลี้ยง</label>
                                                <input type="text" class="form-control" id="Gname" name="Gname" style="border-radius: 30px;" value="<?= $gf_name; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">เลขประจำตัวประชาชน</label>
                                                <input type="text" class="form-control" id="personid" name="personid" style="border-radius: 30px;" value="<?= $agc_personid; ?>" readonly required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" id="phone" name="phone" style="border-radius: 30px;" value="<?= $agc_phone; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">ระดับการศึกษา</label>
                                                <select class="form-control" aria-label="Default select example" id="edu" name="edu" style="border-radius: 30px;" required>
                                                    <option <?php if($agc_edu == '1') echo "selected"; ?> value="1" >ประถมศึกษา</option>
                                                    <option <?php if($agc_edu == '2') echo "selected"; ?> value="2" >มัธยมศึกษา</option>
                                                    <option <?php if($agc_edu == '3') echo "selected"; ?> value="3" >ปวช.</option>
                                                    <option <?php if($agc_edu == '4') echo "selected"; ?> value="4" >ปวส.</option>
                                                    <option <?php if($agc_edu == '5') echo "selected"; ?> value="5" >ปริญาตรี</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">ประสบการณ์เลี้ยง</label>
                                                <select class="form-control" aria-label="Default select example" id="exper" name="exper" style="border-radius: 30px;" required>
                                                    <option <?php if($agc_exper == '1') echo "selected"; ?> value="1">1-2 ปี</option>
                                                    <option <?php if($agc_exper == '2') echo "selected"; ?> value="2">3-5 ปี</option>
                                                    <option <?php if($agc_exper == '3') echo "selected"; ?> value="3">5 ปีขึ้นไป</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">จุดประสงค์เลี้ยง</label>
                                                <select class="form-control" aria-label="Default select example" id="obj" name="obj" style="border-radius: 30px;" required>
                                                    <option <?php if($agc_obj == '1') echo "selected"; ?> value="1">เพื่อขุนขาย</option>
                                                    <option <?php if($agc_obj == '2') echo "selected"; ?> value="2">เพื่อขายพ่อ-แม่พันธุ์</option>
                                                    <option <?php if($agc_obj == '3') echo "selected"; ?> value="3">เพื่อขุนขายและขายพ่อ-แม่พันธุ์</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="inputState" class="form-label">ประเภทลี้ยง</label>
                                                <select class="form-control" aria-label="Default select example" id="type" name="type" style="border-radius: 30px;" required>
                                                    <option <?php if($agc_type == '1') echo "selected"; ?> value="1">แบบยืนโรง</option>
                                                    <option <?php if($agc_type == '2') echo "selected"; ?> value="2">แบบกึ่ง</option>
                                                    <option <?php if($agc_type == '3') echo "selected"; ?> value="3">แบบธรรมชาติ</option>
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