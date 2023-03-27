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

    <title>สรุปยอดขายแพะ</title>

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
                                    <h2 class="m-0 font-weight-bold text-primary">สรุปยอดขายแพะ</h2>
                                </div>
                                <div class="card-body">
                                    <form action="Report_salegoat.php?" method="post">
                                        <div class="row mt-2">
                                            <div class="col-md-3"></div>
                                            <label for="inputState" class="form-label mt-2">ตั้งแต่วันที่</label>
                                            <div class="col-md-2">
                                                <input type="date" style="border-radius: 30px;" name="start_date" class="form-control" required>
                                            </div>
                                            <label for="inputState" class="form-label mt-2">ถึงวันที่</label>
                                            <div class="col-md-2">
                                                <input type="date" style="border-radius: 30px;" name="end_date" class="form-control" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success" style="border-radius: 30px;" type="submit" name="submit">ออกรายงาน</button>
                                            </div>
                                        
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>ลำดับที่</th>
                                                    <th>ประเภทแพะ</th>
                                                    <!-- <th>เดือนที่ขาย</th> -->
                                                    <th>จำนวนยอดขายแพะ</th>
                                                    <!-- <th>ชื่อเกษตรกร</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    if(isset($_POST["submit"])){
                                                        $start_date = $_POST["start_date"];
                                                        $end_date = $_POST["end_date"];
                                                        $count = 1;
                                                        $stmt = $db->query("SELECT group_g.gg_type , MONTH(sale.sale_date) as month , SUM(salelist.slist_price) as total , agriculturist.agc_name
                                                                            FROM `salelist` 
                                                                            INNER JOIN `sale` ON sale.sale_id = salelist.sale_id
                                                                            INNER JOIN `group_g` ON group_g.gg_id = salelist.gg_id 
                                                                            INNER JOIN `agriculturist` ON group_g.agc_id = agriculturist.agc_id
                                                                            WHERE MONTH(sale.sale_date) BETWEEN MONTH('2023-01-01') AND MONTH('2023-03-31')
                                                                            GROUP BY  group_g.gg_type , MONTH(sale.sale_date)");
                                                        $stmt->execute();
                                                        $vms = $stmt->fetchAll();

                                                        if (!$vms) {
                                                            echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                                        } else {
                                                            foreach($vms as $vm)  {  
                                                ?>
                                                <tr>
                                                    <th scope="row"><?= $count; ?></th>
                                                    <td>
                                                        <?php 
                                                            if($vm['gg_type'] == 1){
                                                                echo "พ่อพันธุ์";
                                                            }elseif($vm['gg_type'] == 2){
                                                                echo "แม่พันธุ์";
                                                            }else{
                                                                echo "แพะขุน";
                                                            }
                                                        ?>
                                                    </td>
                                                    <!-- <td>
                                                        <?php 
                                                            if($vm['month'] == 1){
                                                                echo "พ่อพันธุ์";
                                                            }elseif($vm['month'] == 2){
                                                                echo "แม่พันธุ์";
                                                            }else{
                                                                echo "แพะขุน";
                                                            }
                                                        ?>
                                                    </td> -->
                                                    <td><?= $vm['total']; ?></td>
                                                    <!-- <td><?= $vm['agc_name']; ?></td> -->
                                                </tr>
                                                <?php    $count++;   }  
                                                        } 
                                                    }    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="chart-area mb-5">
                                                <canvas id="myChartBar" height="280"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="chart-area mb-5">
                                                <canvas id="myAreaChart" height="130"></canvas>
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

    <script type="text/javascript">

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

        var my_data = [];
        var my_label = [];
        // $vms.forEach(item => {
        //     my_data.push(item.total)
        //     switch (item.gg_type) {
        //         case '1':
        //             my_label.push('พ่อพันธุ์')
        //             break;
        //         case '2':
        //             my_label.push('แม่พันธุ์')
        //             break;
        //         case '3':
        //             my_label.push('ขุน')
        //             break;
        //     }
        // });

        
        var ctx = document.getElementById('myChartBar');
        var myChartBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["แพะพ่อพันธุ์","แพะแม่พันธุ์","แพะขุน"],
                datasets: [{
                label: "แพะพ่อพันธุ์",
                backgroundColor: "#2a86e9",
                borderColor: "#2a86e9",
                data: [6500, 8400, 7800, 9500, 8500, 7500, 10000, 9500, 7700, 8400, 6900, 5800]
                },{
                label: "แพะแม่พันธุ์",
                backgroundColor: "#2ae955",
                borderColor: "#2ae955",
                data: [6500, 8400, 7800, 9500, 8500, 7500, 10000, 9500, 7700, 8400, 6900, 5800]
                }, {
                label: "แพะขุน",
                backgroundColor: "#e9452a",
                borderColor: "#e9452a",
                data: [6500, 8400, 7800, 9500, 8500, 7500, 10000, 9500, 7700, 8400, 6900, 5800]
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: false
                }
            }
        });



        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ษ.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค", "พ.ย.", "ธ.ค"],
                datasets: [{
                    label: "รายได้แฝง",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.07)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [6500, 8400, 7800, 9500, 8500, 7500, 10000, 9500, 7700, 8400, 6900, 5800],
                },{
                    label: "รายจ่าย",
                    lineTension: 0.3,
                    backgroundColor: "rgba(255,23,0,0.07)",
                    borderColor: "rgba(255,23,0,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255,23,0,1)",
                    pointBorderColor: "rgba(255,23,0,1)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(178,21,6,1)",
                    pointHoverBorderColor: "rgba(178,21,6,1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [5690, 6870, 7450, 6500, 6540, 5870, 6840, 6500, 7800, 8500, 4580, 3500],
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: false
                }
            }
        });

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