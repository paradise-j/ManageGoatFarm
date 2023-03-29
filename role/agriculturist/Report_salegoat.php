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

    <title>รายงานการขายแพะ</title>

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
                                    <h2 class="m-0 font-weight-bold text-primary">สรุปยอดขายแพะทั้งหมดละกลุ่มเลี้ยง</h2>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="row mt-2 mb-4">
                                            <div class="col-md-1"></div>
                                            <label for="inputState" class="form-label mt-2">กลุ่มเลี้ยง</label>
                                            <div class="col-md-3">
                                                <select class="form-control" aria-label="Default select example" id="Gname" name="Gname" style="border-radius: 30px;" required>
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
                                            <div class="col-md-2">
                                                <input type="date" style="border-radius: 30px;" id="start_date" name="start_date" class="form-control" required>
                                            </div>
                                            <label for="inputState" class="form-label mt-2">ถึงวันที่</label>
                                            <div class="col-md-2">
                                                <input type="date" style="border-radius: 30px;" id="end_date" name="end_date" class="form-control" required>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-success" style="border-radius: 30px;" type="submit" name="submit">เรียกดู</button>
                                                <!-- <button class="btn btn-danger" style="border-radius: 30px;" type="submit" name="submit" onclick="ResetDate()">คืนค่าเริ้มต้น</button> -->
                                            </div>
                                        </div>
                                    </form>
                                    <?php 
                                        if(isset($_POST["submit"])){
                                            $Gname = $_POST["Gname"];
                                            $start_date = $_POST["start_date"];
                                            $end_date = $_POST["end_date"];
                                            $count = 1;

                                            $stmt2 = $db->query("SELECT SUM(salelist.slist_price) as total , MONTH(sale_date) as month
                                                                FROM `sale` 
                                                                INNER JOIN `salelist` ON sale.sale_id = salelist.sale_id 
                                                                INNER JOIN agriculturist ON sale.agc_id = agriculturist.agc_id
                                                                INNER JOIN group_farm ON group_farm.gf_id = agriculturist.gf_id
                                                                WHERE group_farm.gf_id ='$Gname' AND MONTH(sale_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                                                GROUP BY MONTH(sale_date)"); 
                                            $stmt2->execute();

                                            $arr2 = array();
                                            while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                                $arr2[] = $row;
                                            }
                                            $dataResult2 = json_encode($arr2);

                                            $stmt1 = $db->query("SELECT group_g.gg_type , MONTH(sale.sale_date) as month , SUM(salelist.slist_price) as total
                                                                    FROM `salelist` 
                                                                    INNER JOIN `sale` ON sale.sale_id = salelist.sale_id
                                                                    INNER JOIN `group_g` ON group_g.gg_id = salelist.gg_id 
                                                                    INNER JOIN `agriculturist` ON group_g.agc_id = agriculturist.agc_id
                                                                    INNER JOIN `group_farm` ON group_farm.gf_id = agriculturist.gf_id
                                                                    WHERE group_farm.gf_id ='$Gname' AND MONTH(sale.sale_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                                                    GROUP BY  group_g.gg_type , MONTH(sale.sale_date)");
                                            $stmt1->execute();

                                            $arr = array();
                                            while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                                $arr[] = $row;
                                            }
                                            $dataResult = json_encode($arr);


                                            $stmt = $db->query("SELECT group_g.gg_type , MONTH(sale.sale_date) as month , SUM(salelist.slist_price) as total
                                                                FROM `salelist` 
                                                                INNER JOIN `sale` ON sale.sale_id = salelist.sale_id
                                                                INNER JOIN `group_g` ON group_g.gg_id = salelist.gg_id 
                                                                WHERE MONTH(sale.sale_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                                                GROUP BY  group_g.gg_type , MONTH(sale.sale_date)");
                                            $stmt->execute();                                                        
                                            $vms = $stmt->fetchAll();
                                        }
                                    ?>
                                </div>
                            
                                <div class="row ml-2 mb-4 mr-2">
                                    <div class="col-xl-5 col-lg-4">
                                        <div class="card shadow">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปยอดขายแพะแต่ละประเภท</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-area">
                                                    <canvas id="myChartBar" ></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-8">
                                        <div class="card shadow">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปยอดขายแพะในแต่ละเดือน</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-area">
                                                    <canvas id="myAreaChart" ></canvas>
                                                    
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
// ============================================= myChartBar =============================================
        const my_dataAll = <?= $dataResult; ?> ; 
        var my_data1 = [];
        var my_data2 = [];
        var my_data3 = [];
        var my_label = [];
        var Unique_label = [];
        my_dataAll.forEach(item => {
            switch (item.gg_type) {
                case '1':
                    switch (item.month) {
                        case '1':
                            my_data1.push(item.total)
                            break;
                        case '2':
                            my_data1.push(item.total)
                            break;
                        case '3':
                            my_data1.push(item.total)
                            break;
                        case '4':
                            my_data1.push(item.total)
                            break;
                        case '5':
                            my_data1.push(item.total)
                            break;
                        case '6':
                            my_data1.push(item.total)
                            break;
                        case '7':
                            my_data1.push(item.total)
                            break;
                        case '8':
                            my_data1.push(item.total)
                            break;
                        case '9':
                            my_data1.push(item.total)
                            break;
                        case '10':
                            my_data1.push(item.total)
                            break;
                        case '11':
                            my_data1.push(item.total)
                            break;
                        case '12':
                            my_data1.push(item.total)
                            break;
                        }
                    break;
                case '2':
                    switch (item.month) {
                        case '1':
                            my_data2.push(item.total)
                            break;
                        case '2':
                            my_data2.push(item.total)
                            break;
                        case '3':
                            my_data2.push(item.total)
                            break;
                        case '4':
                            my_data2.push(item.total)
                            break;
                        case '5':
                            my_data2.push(item.total)
                            break;
                        case '6':
                            my_data2.push(item.total)
                            break;
                        case '7':
                            my_data2.push(item.total)
                            break;
                        case '8':
                            my_data2.push(item.total)
                            break;
                        case '9':
                            my_data2.push(item.total)
                            break;
                        case '10':
                            my_data2.push(item.total)
                            break;
                        case '11':
                            my_data2.push(item.total)
                            break;
                        case '12':
                            my_data2.push(item.total)
                            break;
                        }
                    break;
                case '3':
                    switch (item.month) {
                        case '1':
                            my_data3.push(item.total)
                            break;
                        case '2':
                            my_data3.push(item.total)
                            break;
                        case '3':
                            my_data3.push(item.total)
                            break;
                        case '4':
                            my_data3.push(item.total)
                            break;
                        case '5':
                            my_data3.push(item.total)
                            break;
                        case '6':
                            my_data3.push(item.total)
                            break;
                        case '7':
                            my_data3.push(item.total)
                            break;
                        case '8':
                            my_data3.push(item.total)
                            break;
                        case '9':
                            my_data3.push(item.total)
                            break;
                        case '10':
                            my_data3.push(item.total)
                            break;
                        case '11':
                            my_data3.push(item.total)
                            break;
                        case '12':
                            my_data3.push(item.total)
                            break;
                        }
                    break;
            }
            switch (item.month) {
                case '1':
                    my_label.push('มกราคม')
                    break;
                case '2':
                    my_label.push('กุมภาพันธ์')
                    break;
                case '3':
                    my_label.push('มีนาคม')
                    break;
                case '4':
                    my_label.push('เมษายน')
                    break;
                case '5':
                    my_label.push('พฤษภาคม')
                    break;
                case '6':
                    my_label.push('มิถุนายน')
                    break;
                case '7':
                    my_label.push('กรกฎาคม')
                    break;
                case '8':
                    my_label.push('สิงหาคม')
                    break;
                case '9':
                    my_label.push('กันยายน')
                    break;
                case '10':
                    my_label.push('ตุลาคม')
                    break;
                case '11':
                    my_label.push('พฤศจิกายน')
                    break;
                case '12':
                    my_label.push('ธันวาคม')
                    break; 
            }
        });

        for( var i=0; i<my_label.length; i++ ) {
            if ( Unique_label.indexOf( my_label[i] ) < 0 ) {
            Unique_label.push( my_label[i] );
            }
        } 
        console.log(my_data1);
        console.log(Unique_label);

        var ctx = document.getElementById('myChartBar');
        var myChartBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Unique_label,
                datasets: [{
                label: "แพะพ่อพันธุ์",
                backgroundColor: "#2a86e9",
                borderColor: "#2a86e9",
                data: my_data1
                },{
                label: "แพะแม่พันธุ์",
                backgroundColor: "#2ae955",
                borderColor: "#2ae955",
                data: my_data2
                }, {
                label: "แพะขุน",
                backgroundColor: "#e9452a",
                borderColor: "#e9452a",
                data: my_data3
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true
                }
            }
        });

// ============================================= myAreaChart =============================================
        const my_dataAll2 = <?= $dataResult2; ?> ; 
        var my_data02 = [];
        var my_label02 = [];
        my_dataAll2.forEach(item => {
            my_data02.push(item.total)
            switch (item.month) {
                case '1':
                    my_label02.push('มกราคม')
                    break;
                case '2':
                    my_label02.push('กุมภาพันธ์')
                    break;
                case '3':
                    my_label02.push('มีนาคม')
                    break;
                case '4':
                    my_label02.push('เมษายน')
                    break;
                case '5':
                    my_label02.push('พฤษภาคม')
                    break;
                case '6':
                    my_label02.push('มิถุนายน')
                    break;
                case '7':
                    my_label02.push('กรกฎาคม')
                    break;
                case '8':
                    my_label02.push('สิงหาคม')
                    break;
                case '9':
                    my_label02.push('กันยายน')
                    break;
                case '10':
                    my_label02.push('ตุลาคม')
                    break;
                case '11':
                    my_label02.push('พฤศจิกายน')
                    break;
                case '12':
                    my_label02.push('ธันวาคม')
                    break; 
            }
        });
        
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: my_label02,
                datasets: [{
                    label: "ยอดขายสุทธิ",
                    lineTension: 0,
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
                    data: my_data02,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 12
                    },
                        maxBarThickness: 50,
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            // max: 25000,
                        }
                    }],
                },
                legend: {
                    display: true
                },
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