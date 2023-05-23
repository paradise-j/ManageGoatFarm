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

    <title>รายงานรายได้แฝง-รายจ่าย</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/clipboard-solid.svg" />
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
                                    <h2 class="m-0 font-weight-bold text-primary">สรุปยอดรายได้แฝง-รายจ่ายทั้งหมด</h2>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="row mt-2">
                                            <div class="col-md-3"></div>
                                            <label for="inputState" class="form-label mt-2">ตั้งแต่วันที่</label>
                                            <div class="col-md-2">
                                                <?php $date = date('Y-m-d'); ?>
                                                <input type="date" style="border-radius: 30px;" id="start_date" name="start_date" class="form-control" required>
                                            </div>
                                            <label for="inputState" class="form-label mt-2">ถึงวันที่</label>
                                            <div class="col-md-2">
                                                <input type="date" style="border-radius: 30px;" id="end_date" name="end_date" max="<?= $date; ?>" class="form-control" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success" style="border-radius: 30px;" type="submit" name="submit">เรียกดู</button>
                                                <!-- <button class="btn btn-danger" style="border-radius: 30px;" type="submit" name="submit" onclick="ResetDate()">คืนค่าเริ้มต้น</button> -->
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <?php 
                                        $id = $_SESSION['id'];
                                        if(isset($_POST["submit"])){
                                            $start_date = $_POST["start_date"];
                                            $end_date = $_POST["end_date"];
                                            $count = 1;
                                            // ===========================================================myAreaChart=================================================================
                                                $stmt2 = $db->query("SELECT `money_type`, MONTH(`money_date`) as month, SUM(`money_quan`) as total 
                                                                    FROM `money_inex` 
                                                                    INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id
                                                                    INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
                                                                    WHERE user_login.user_id = '$id' AND MONTH(`money_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date') 
                                                                    GROUP BY `money_type`, MONTH(`money_date`)"); 
                                                $stmt2->execute();

                                                $arr2 = array();
                                                while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                                    $arr2[] = $row;
                                                }
                                                $dataResult2 = json_encode($arr2);
                                            // echo $dataResult2 ;
                                            // ====================================================myChartBar========================================================================
                                                $stmt1 = $db->query("SELECT MONTH(`money_date`) as month, SUM(`money_quan`) as total 
                                                                    FROM `money_inex` 
                                                                    INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id
                                                                    INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
                                                                    WHERE user_login.user_id = '$id' AND (`money_type`= '1' AND `money_list`= 'ขายมูลแพะ') AND MONTH(`money_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date')  
                                                                    GROUP BY MONTH(`money_date`)");
                                                $stmt1->execute();

                                                $arr = array();
                                                while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                                    $arr[] = $row;
                                                }
                                                $dataResult_type1_1 = json_encode($arr);
                                            // ===========================================================myChartBar1=================================================================
                                                $stmt3 = $db->query("SELECT `money_list`, MONTH(`money_date`) as month, SUM(`money_quan`) as total 
                                                                    FROM `money_inex` 
                                                                    INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id
                                                                    INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
                                                                    WHERE user_login.user_id = '$id' AND `money_type`= '2' AND MONTH(`money_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date')  
                                                                    GROUP BY `money_list`, MONTH(`money_date`)");
                                                $stmt3->execute();

                                                $arr3 = array();
                                                while($row = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                                    $arr3[] = $row;
                                                }
                                                $my_dataAll_money_out = json_encode($arr3);
                                            // ===========================================================myChartBar1=================================================================
                                                $stmt4 = $db->query("SELECT `money_list` , SUM(`money_quan`) as total 
                                                                    FROM `money_inex` 
                                                                    INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id
                                                                    INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
                                                                    WHERE user_login.user_id = '$id' AND `money_type`= '3' AND MONTH(`money_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date') 
                                                                    GROUP BY `money_list`");
                                                $stmt4->execute();

                                                $arr4 = array();
                                                while($row = $stmt4->fetch(PDO::FETCH_ASSOC)){
                                                    $arr4[] = $row;
                                                }
                                                $my_dataAll_money_cost = json_encode($arr4);

                                            // ===========================================================myChartBar1=================================================================



                                            
                                        }
                                    ?>
                                </div>
                            
                                <div class="row mb-2 mr-2 ml-2">
                                    <div class="col-xl-5 col-lg-4">
                                        <div class="card shadow">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปรายได้แฝงในแต่ละเดือน</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-area mt-2">
                                                    <canvas id="myChartBar" ></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-8">
                                        <div class="card shadow mb-2">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปยอดรายได้แฝง-รายจ่ายในแต่ละเดือน</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-area">
                                                    <canvas id="myAreaChart" ></canvas>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 mr-2 ml-2">
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="card shadow">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปการประหยัดค่าปุ๋ย</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-area mt-2">
                                                    <canvas id="myPieChart" ></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-8">
                                        <div class="card shadow mb-2">
                                            <div class="card-header py-3">
                                                <h5 class="m-0 font-weight-bold text-primary">สรุปรายจ่ายในแต่ละประเภท</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- <div class="chart-area "> -->
                                                    <!-- <canvas id="myChartBar2" ></canvas> -->
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                            <thead class="thead-light">
                                                                <tr align="center">
                                                                    <th>ลำดับที่</th>
                                                                    <th>ชื่อรายการ</th>
                                                                    <th>เดือนที่จ่าย</th>
                                                                    <th>ราคา</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    if (isset($_POST["submit"])) {
                                                                    
                                                                        $stmt3 = $db->query("SELECT `money_list`, `money_date` as month, SUM(`money_quan`) as total 
                                                                                            FROM `money_inex` 
                                                                                            INNER JOIN `agriculturist` ON money_inex.agc_id = agriculturist.agc_id
                                                                                            INNER JOIN `user_login` ON user_login.agc_id = agriculturist.agc_id 
                                                                                            WHERE user_login.user_id = '$id' AND `money_type`= '2' AND `money_date` BETWEEN '$start_date' AND '$end_date' 
                                                                                            GROUP BY `money_list`, `money_date`
                                                                                            ORDER BY `money_date`");
                                                                        $stmt3->execute();
                                                                        $mns = $stmt3->fetchAll();
                                                                        $count = 1 ; 
                                                                        if (!$mns) {
                                                                            echo "<p><td colspan='8' class='text-center'>ไม่พบข้อมูล</td></p>";
                                                                        } else {
                                                                        foreach($mns as $mn)  {  
                                                                ?>
                                                                    <tr align="center">
                                                                        <th scope="row"><?= $count ;?> </th>
                                                                        <td><?= $mn['money_list']; ?></td>
                                                                        <td class="date_th"><?= $mn['month']; ?></td>
                                                                        <td><?= number_format($mn['total']); ?></td>
                                                                    </tr>
                                                                <?php $count++ ;?> 
                                                                <?php   }  
                                                                        } 
                                                                    }    ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <!-- </div> -->
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
        const dom_date = document.querySelectorAll('.date_th')
                dom_date.forEach((elem)=>{
                const my_date = elem.textContent
                const date = new Date(my_date)
                const result = date.toLocaleDateString('th-TH', {

                year: 'numeric',
                month: 'long',
                day: 'numeric',

            }) 
                elem.textContent= result
        })
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
// ============================================= myChartBar1 =============================================
        const my_dataAlltype1 = <?= $dataResult_type1_1; ?> ;
        var my_data1 = [];
        var my_label = [];
        // var Unique_label = [];
        my_dataAlltype1.forEach(item => {
            my_data1.push(item.total)
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

        var ctx = document.getElementById('myChartBar');
        var myChartBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: my_label,
                datasets: [{
                label: "ขายมูลแพะ",
                backgroundColor: "#2a86e9",
                borderColor: "#2a86e9",
                data: my_data1
                }],
            },
            options: {
                maintainAspectRatio: false,
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

// ============================================= myAreaChart1 =============================================
            const my_dataAll2 = <?= $dataResult2; ?> ; 
            var my_data01 = [];
            var my_data02 = [];
            var my_label02 = [];
            var Unique_label02 = [];

            my_dataAll2.forEach(item => {
                switch (item.money_type) {
                    case '1':
                        switch (item.month) {
                            case '1':
                                my_data01.push(item.total)
                                break;
                            case '2':
                                my_data01.push(item.total)
                                break;
                            case '3':
                                my_data01.push(item.total)
                                break;
                            case '4':
                                my_data01.push(item.total)
                                break;
                            case '5':
                                my_data01.push(item.total)
                                break;
                            case '6':
                                my_data01.push(item.total)
                                break;
                            case '7':
                                my_data01.push(item.total)
                                break;
                            case '8':
                                my_data01.push(item.total)
                                break;
                            case '9':
                                my_data01.push(item.total)
                                break;
                            case '10':
                                my_data01.push(item.total)
                                break;
                            case '11':
                                my_data01.push(item.total)
                                break;
                            case '12':
                                my_data01.push(item.total)
                                break;
                            }
                        break;
                    case '2':
                        switch (item.month) {
                            case '1':
                                my_data02.push(item.total)
                                break;
                            case '2':
                                my_data02.push(item.total)
                                break;
                            case '3':
                                my_data02.push(item.total)
                                break;
                            case '4':
                                my_data02.push(item.total)
                                break;
                            case '5':
                                my_data02.push(item.total)
                                break;
                            case '6':
                                my_data02.push(item.total)
                                break;
                            case '7':
                                my_data02.push(item.total)
                                break;
                            case '8':
                                my_data02.push(item.total)
                                break;
                            case '9':
                                my_data02.push(item.total)
                                break;
                            case '10':
                                my_data02.push(item.total)
                                break;
                            case '11':
                                my_data02.push(item.total)
                                break;
                            case '12':
                                my_data02.push(item.total)
                                break;
                        }
                    break;
                }
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

        for( var i=0; i<my_label02.length; i++ ) {
            if ( Unique_label02.indexOf( my_label02[i] ) < 0 ) {
                Unique_label02.push( my_label02[i] );
            }
        } 


        // console.log(my_data01);
        // console.log(my_data02);
        // console.log(Unique_label02);


        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Unique_label02,
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
                    data: my_data01,
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
                    // yAxes: [{
                    //     ticks: {
                    //         min: 0,
                    //         // max: 25000,
                    //     }
                    // }],
                },
                legend: {
                    display: true
                },
            }
            
        });
// ============================================= myChartBar2 =============================================

        // const my_dataAll_money_out = <?= $my_dataAll_money_out; ?> ;
        // var my_data_out1 = [];
        // var my_data_out2 = [];
        // var my_data_out3 = [];
        // var my_label_out = [];
        // // var Unique_label = [];
        // my_dataAll_money_out.forEach(item => {
        //     switch (item.money_type) {
        //         case '1':
        //             switch (item.month) {
        //                 case '1':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '2':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '3':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '4':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '5':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '6':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '7':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '8':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '9':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '10':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '11':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 case '12':
        //                     my_data_out1.push(item.total)
        //                     break;
        //                 }
        //             break;
        //         case '2':
        //             switch (item.month) {
        //                 case '1':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '2':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '3':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '4':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '5':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '6':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '7':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '8':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '9':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '10':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '11':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 case '12':
        //                     my_data_out2.push(item.total)
        //                     break;
        //                 }
        //             break;
        //         case '3':
        //             switch (item.month) {
        //                 case '1':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '2':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '3':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '4':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '5':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '6':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '7':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '8':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '9':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '10':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '11':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 case '12':
        //                     my_data_out3.push(item.total)
        //                     break;
        //                 }
        //             break;
        //     }
        //     switch (item.month) {
        //             case '1':
        //                 my_label_out.push('มกราคม')
        //                 break;
        //             case '2':
        //                 my_label_out.push('กุมภาพันธ์')
        //                 break;
        //             case '3':
        //                 my_label_out.push('มีนาคม')
        //                 break;
        //             case '4':
        //                 my_label_out.push('เมษายน')
        //                 break;
        //             case '5':
        //                 my_label_out.push('พฤษภาคม')
        //                 break;
        //             case '6':
        //                 my_label_out.push('มิถุนายน')
        //                 break;
        //             case '7':
        //                 my_label_out.push('กรกฎาคม')
        //                 break;
        //             case '8':
        //                 my_label_out.push('สิงหาคม')
        //                 break;
        //             case '9':
        //                 my_label_out.push('กันยายน')
        //                 break;
        //             case '10':
        //                 my_label_out.push('ตุลาคม')
        //                 break;
        //             case '11':
        //                 my_label_out.push('พฤศจิกายน')
        //                 break;
        //             case '12':
        //                 my_label_out.push('ธันวาคม')
        //                 break; 
        //         } 

        // });

        // console.log("my_data_out1 => " + my_data_out1)
        // console.log("my_data_out2 => " + my_data_out2)
        // console.log("my_data_out2 => " + my_data_out2)
        // console.log("my_label_out => " + my_label_out)

        // var ctx = document.getElementById('myChartBar2');
        // var myChartBar2 = new Chart(ctx, {
        //     type: 'bar',
        //     data: {
        //         labels: my_label_out,
        //         datasets: [{
        //         axis: 'y',
        //         label: "ค่ายา",
        //         backgroundColor: "#2a86e9",
        //         borderColor: "#2a86e9",
        //         data: my_data_out1
        //         },{
        //         axis: 'y',
        //         label: "ค่าวัคซีน",
        //         backgroundColor: "#4bc0c0",
        //         borderColor: "#4bc0c0",
        //         data: my_data_out2
        //         },{
        //         axis: 'y',
        //         label: "ค่าอาหาร",
        //         backgroundColor: "#9966ff",
        //         borderColor: "#9966ff",
        //         data: my_data_out2
        //         }],
        //     },
        //     options: {
        //         maintainAspectRatio: false,
        //         // indexAxis: 'y',
        //         scales: {
        //             xAxes: [{
        //             time: {
        //                 unit: 'month'
        //             },
        //             gridLines: {
        //                 display: false,
        //                 drawBorder: true
        //             },
        //             ticks: {
        //                 maxTicksLimit: 5
        //             },
        //                 maxBarThickness: 50,
        //             }],
        //             yAxes: [{
        //                 ticks: {
        //                     min: 0,
        //                     // max: 25000,
        //                 }
        //             }],
        //         },
        //         legend: {
        //             display: true
        //         },
        //     }
        // });



// ============================================= myPieChart =============================================

        const my_dataAll_money_cost = <?= $my_dataAll_money_cost; ?> ;
        var my_data_cost = [];
        var my_label_cost = [];

        var ctx = document.getElementById("myPieChart");
        
        my_dataAll_money_cost.forEach(item => {
            my_data_cost.push(item.total)
            switch (item.money_list) {
                case 'ค่าน้ำมันตัดหญ้า':
                my_label_cost.push('ค่าน้ำมันตัดหญ้า')
                break;
                case 'ค่าปุ๋ย':
                my_label_cost.push('ค่าปุ๋ย')
                break;
            }
        });
        var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: my_label_cost,
            datasets: [{
            data: my_data_cost,
            backgroundColor: ['#2a86e9', '#2ae955', '#e9452a'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            plugins: {
            // Change options for ALL labels of THIS CHART
            datalabels: {
                color: '#36A2EB'
            }
            },
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
            display: true
            },
            cutoutPercentage: 50,
        },
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