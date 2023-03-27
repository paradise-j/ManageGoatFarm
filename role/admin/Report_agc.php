<?php 
    // header('Content-Type: application/json; charset=utf-8');
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
                                    <form action="" method="post">
                                        <div class="row mt-4 mb-5">
                                            <div class="col-md-2"></div>
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
                                            <div class="col-md-2">
                                                <button class="btnsmall btn-success" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">เรียกดู</button>
                                                <!-- &nbsp&nbsp -->
                                                <!-- <button class="btnsmall btn-info" style="border-radius: 30px; font-size: 0.8rem;" type="submit" name="submit">คืนค่าเริ่มต้น</button> -->
                                            </div>                       
                                            <!-- <div class="col text-right">
                                                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                                    class="fas fa-download fa-sm text-white-50"></i>  ออกรายงาน</a>
                                            </div> -->
                                        </div>
                                    </form>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="card shadow">
                                        <div class="card-header py-3">
                                            <h5 class="m-0 font-weight-bold text-primary">สรุปยอดเกษตรแต่ละกลุ่มเลี้ยง</h5>
                                        </div>
                                            <div class="card-body mb-5">
                                                <div class="chart-area mb-5">
                                                    <canvas id="myChartBar" height="240"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card shadow">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปยอดเกษตรแต่ละกลุ่มเลี้ยง</h5>
                                            </div>
                                            <div class="card-body mb-5">
                                                <div class="chart-area mb-5">
                                                    <canvas id="myAreaChart" height="165"></canvas>
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
        // console.log(my_data1);
        // console.log(Unique_label);

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