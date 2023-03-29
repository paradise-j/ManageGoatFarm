<?php 
    // header('Content-Type: application/json; charset=utf-8');
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 5){
        header("location: ../../index.php");
        exit;
    }

    require_once 'connect.php';

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `gdis_data` WHERE `gdis_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Manage_disease.php");
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

    <title>รายงานข้อมูลเกษตรกร</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/virus.png" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/daterangepicker.css" rel="stylesheet">
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
                                    <h2 class="m-0 font-weight-bold text-primary">รายงานข้อมูลเกษตรกร</h2>
                                </div>
                                <div class="card-body">
                                    <!-- <form action="" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-1"></div>
                                            <label class="form-label mt-2">กลุ่มเลี้ยง</label>
                                            <div class="col-md-3">
                                                <select class="form-control" aria-label="Default select example" id="Gname" name="Gname" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือกกลุ่มเลี้ยง....</option>
                                                    <?php 
                                                        $stmt = $db->query("SELECT * FROM `group_farm`");
                                                        $stmt->execute();
                                                        $gfs = $stmt->fetchAll();
                                                        
                                                        foreach($gfs as $gf){
                                                    ?>
                                                    <option value="<?= $gf['gf_name']?>"><?= $gf['gf_name']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btnsmall btn-success" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit" onclick="filterdata()" >เรียกดู</button>
                                            </div>                       
                                        </div>
                                    </form> -->
                                <?php
                                    $stmt = $db->query("SELECT COUNT(`agc_id`) as total , group_farm.gf_name 
                                                        FROM `agriculturist` 
                                                        INNER JOIN `group_farm` ON group_farm.gf_id = agriculturist.gf_id 
                                                        GROUP BY group_farm.gf_name");
                                    $stmt->execute();
                                    $arr = array();
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        $arr[] = $row;
                                    }
                                    $dataResultAll = json_encode($arr);
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card shadow">
                                        <div class="card-header py-3">
                                            <h5 class="m-0 font-weight-bold text-primary">สรุปยอดเกษตรแต่ละกลุ่มเลี้ยง</h5>
                                        </div>
                                            <div class="card-body">
                                                <div class="chart-area mt-2">
                                                    <!-- <canvas id="myChartBar" height="240"></canvas> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card shadow">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปยอดเกษตรแต่ละกลุ่มเลี้ยง</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-area mt-4">
                                                    <canvas id="myPieChart"></canvas>
                                                </div>
                                            </div>
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

    <script src="js/moment.min.jss"></script>
    <script src="js/jquery.inputmask.min.js"></script>

    <script src="js/daterangepicker.js"></script>
    <script src="js/validation.js"></script>

    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chartjs-plugin-datalabels.js"></script>

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

    <script type="text/javascript">
        const my_dataAll = <?= $dataResultAll; ?> ; 
        var my_data = [];
        var my_label = [];

        my_dataAll.forEach(item => {
            my_data.push(item.total)
            my_label.push(item.gf_name)

        });

        console.log(my_data)
        console.log(my_label)
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: my_label,
                datasets: [{
                data: my_data,
                backgroundColor: ['#2a86e9', '#2ae955', '#e9452a'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#36A2EB'
                    }
                },
                maintainAspectRatio: true,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                caretPadding: 10,
                },
                legend: {
                display: true
                },
                cutoutPercentage: 65,
            },
        });

        // function filterdata(){
        //     var GName = document.getElementById('Gname').value;
        //     console.log(GName)
        //     myPieChart.data.labels = GName;
        //     myPieChart.update();
            
        // } 


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
                                url: 'Manage_disease.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Manage_disease.php';
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



        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                    "sProcessing": "กำลังดำเนินการ...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดงรายการ 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกรายการ)",
                    "sInfoPostFix": "",
                    "sSearch": "ค้นหา:",
                    "sUrl": "",
                    "oPaginate": {
                                    "sFirst": "เริ่มต้น",
                                    "sPrevious": "ก่อนหน้า",
                                    "sNext": "ถัดไป",
                                    "sLast": "สุดท้าย"
                    }
            }
        });
        $('.table').DataTable();

    </script>

</body>

</html>