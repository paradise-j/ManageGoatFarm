<?php 
    session_start();
    if (!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1) {
        header("Location: ../../index.php");
        exit;
    }
    require_once("connect.php");
    // echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>หน้าหลัก</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/png" href="img/home.png">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?><!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('Topbar.php'); ?><!-- Topbar -->
                <div class="container-fluid">
                    <form action="api/get_date.php" method="post">
                        <div class="row mb-2">
                            <label class="form-label mt-2">ตั้งแต่วันที่</label>
                            <div class="col-md-2">
                                <input type="date" style="border-radius: 30px;" id="start_date" name="start_date" class="form-control" required>
                            </div>
                            <label class="form-label mt-2">ถึงวันที่</label>
                            <div class="col-md-2">
                                <input type="date" style="border-radius: 30px;" id="end_date" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <button class="btnsmall btn-success" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">เรียกดู</button>
                                &nbsp&nbsp
                                <button class="btnsmall btn-info" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">คืนค่าเริ่มต้น</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mb-2">
                        <label class="form-label mt-2">จังหวัด</label>
                        <div class="col-md-2">
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
                        <label class="form-label mt-2">อำเภอ</label>
                        <div class="col-md-2">
                            <select class="form-control" aria-label="Default select example" id="amphures" name="amphures" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกอำเภอ....</option>
                            </select>
                        </div>
                        <label class="form-label mt-2">ตำบล</label>
                        <div class="col-md-2">
                            <select class="form-control" aria-label="Default select example" id="districts" name="districts" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกตำบล....</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btnsmall btn-success" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">เรียกดู</button>
                            &nbsp&nbsp
                            <button class="btnsmall btn-info" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">คืนค่าเริ่มต้น</button>
                        </div>                       
                        <!-- <div class="col text-right">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i>  ออกรายงาน</a>
                        </div> -->
                    </div>
                    <div class="row mb-3">
                        <label class="form-label mt-2">กลุ่มเลี้ยง</label>
                        <div class="col-md-3">
                            <select class="form-control" aria-label="Default select example" id="gfarm" name="gfarm" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกกลุ่มเลี้ยง....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `group_farm`");
                                    $stmt->execute();
                                    $gfs = $stmt->fetchAll();
                                    
                                    foreach($gfs as $gf){
                                ?>
                                <option value="<?= $gf['gf_id']?>"><?= $gf['gf_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btnsmall btn-success" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">เรียกดู</button>
                            &nbsp&nbsp
                            <button class="btnsmall btn-info" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">คืนค่าเริ่มต้น</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-left-primary shadow h-80">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">จำนวนกลุ่ม</div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT COUNT(`Gf_id`) as total_gfarm FROM `group_farm`");
                                                    $stmt->execute();
                                                    $Gfs = $stmt->fetchAll();
                                                    foreach($Gfs as $Gf){
                                                        echo $Gf['total_gfarm'];
                                                    }
                                                ?>
                                                กลุ่ม
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="card border-left-success shadow h-80">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-success text-uppercase mb-1">จำนวนเกษตรกร</div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT COUNT(`agc_id`) as total_agc FROM `agriculturist`");
                                                    $stmt->execute();
                                                    $agcs = $stmt->fetchAll();
                                                    foreach($agcs as $agc){
                                                        echo $agc['total_agc'];
                                                    }
                                                ?>
                                                คน
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="card border-left-info shadow h-80">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-info text-uppercase mb-1">จำนวนแพะทั้งหมด</div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT SUM(`gg_quantity`) as total FROM `group_g`");
                                                    $stmt->execute();
                                                    $ggs = $stmt->fetchAll();
                                                    foreach($ggs as $gg){
                                                        echo $gg['total'];
                                                    }
                                                ?>
                                                 ตัว
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <img src="img/Goat_gray.png" width="58">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-md font-weight-bold text-warning text-uppercase mb-1">จำนวนแพะทั้งหมด</div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT SUM(`gg_quantity`) as total FROM `group_g`");
                                                    $stmt->execute();
                                                    $ggs = $stmt->fetchAll();
                                                    foreach($ggs as $gg){
                                                        echo $gg['total'];
                                                    }
                                                ?>
                                                 ตัว
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">สรุปยอดขายแพะแต่ละประเภท</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="myBarChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-2">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">สรุปยอดแพะทั้งหมด</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-3 text-center small"> 
                                        <span class="mr-2">
                                            <i class="fas fa-circle"></i> สรุปยอดของแพะแต่ละประเภท
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-2">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">สรุปยอดแพะทั้งหมด</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <!-- <canvas id="myPieChart"></canvas> -->
                                    </div>
                                    <div class="mt-3 text-center small"> 
                                        <span class="mr-2">
                                            <i class="fas fa-circle"></i> สรุปยอดของแพะแต่ละประเภท
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">สรุปยอดขายแพะแต่ละเดือน</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <!-- <canvas id="myAreaChart2"></canvas> -->
                                        <canvas id="myBarChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">สรุปรายได้แฝง-รายจ่ายทั้งหมด</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">สถานะการเป็นโรคของแพะทั้งหมด</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive scrollbar">
                                        <table class="table" id="dataTable" width="100%" cellspacing="0" >
                                            <thead>
                                                <tr align="center" style="font-size: 0.8em;">
                                                    <th>ชื่อฟาร์ม</th>
                                                    <th>ชื่อโรค</th>
                                                    <th>สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $stmt = $db->query("SELECT agriculturist.agc_nfarm , gdis_data.gdis_name , g_disease.gd_level 
                                                                        FROM `g_disease` 
                                                                        INNER JOIN `gdis_data` ON gdis_data.gdis_id = g_disease.gdis_id
                                                                        INNER JOIN `group_g` ON group_g.gg_id = g_disease.gg_id
                                                                        INNER JOIN `agriculturist` ON agriculturist.agc_id = group_g.agc_id");
                                                    $stmt->execute();
                                                    $ggs = $stmt->fetchAll();
                                                    if (!$ggs) {
                                                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                                    } else {
                                                    foreach($ggs as $gg)  {  
                                                ?>
                                                <tr align="center" style="font-size: 0.8em;">
                                                    <td><?= $gg['agc_nfarm']; ?></td>
                                                    <td><?= $gg['gdis_name']; ?></td>
                                                    <td>
                                                        <?php 
                                                            if($gg['gd_level'] == 1){
                                                        ?>
                                                                <span class="btnsmall btnsmall-success" style="border-radius: 30px; font-size: 0.8em;">ไม่รุนแรง</span>
                                                        <?php
                                                            }elseif($gg['gd_level'] == 2){
                                                        ?>
                                                                <span class="btnsmall btnsmall-warning" style="border-radius: 30px; font-size: 0.8em;">ปานกลาง</span>
                                                        <?php
                                                            }else{
                                                        ?>
                                                                <span class="btnsmall btnsmall-danger" style="border-radius: 30px; font-size: 0.8em;">รุนแรงมาก</span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
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
                </div>
            </div>
            <?php include("footer.php") ?><!-- Footer -->
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chartjs-plugin-datalabels.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-area2-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
    <script src="js/demo/chart-bar2-demo.js"></script>
    <script src="js/demo/chart-update-bar-demo.js"></script>
    

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

        function filterData() {
            const start_date = document.getElementById("start_date").value;
            const end_date = document.getElementById("end_date").value;

        }
    </script>
</body>

</html>