<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `agriculturist` WHERE `agc_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Manage_agc.php");
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

        <title>จัดการข้อมูลเกษตรกร</title>

        <!-- Custom fonts for this template -->
        <link rel="icon" type="image/png" href="img/edit_pro.png" />
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
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
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 text-center">
                                <h3 class="m-0 font-weight-bold text-primary">จัดการข้อมูลเกษตรกร</h3>
                            </div>
                            <div class="row mt-4 ml-2">
                                <div class="col">
                                    <a href="Add_agc.php" class="btn btn-blue" style="border-radius: 30px;" type="submit">เพิ่มข้อมูลเกษตรกร</a>
                                    <!-- <button class="btn btn-blue" style="border-radius: 30px;" type="submit">เพิ่มข้อมูลเกษตรกร</button> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>รหัสเกษตรกร</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>ชื่อฟาร์ม</th>
                                                <th>ตำแหน่ง</th>
                                                <th>ชื่อกลุ่มเลี้ยง</th>
                                                <th>เบอร์โทรศัพท์</th>
                                                <th>รูปภาพ</th>
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
                                                <td>
                                                    <?php 
                                                        if($agc['agc_position_G'] == 1 ) {
                                                            echo "ประธานกลุ่ม";
                                                        }elseif($agc['agc_position_G'] == 2){
                                                            echo "รองประธานกลุ่ม";
                                                        }elseif($agc['agc_position_G'] == 3){
                                                            echo "เลขานุการ";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if($agc['agc_gfarm'] == 1 ) {
                                                            echo "วิสาหกิจชุมชนเกษตรปศุสัตว์บ้านในเสียด";
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $agc['agc_phone']; ?></td>
                                                <td width="100px"><img class="rounded" width="100%" src="uploads/<?= $agc['agc_img']; ?>" alt=""></td>
                                                <td><a href="Edit_agc.php?edit_id=<?= $agc['agc_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid fa-pen-to-square"></a></td>
                                                <td><a data-id="<?= $agc['agc_id']; ?>" href="?delete=<?= $agc['agc_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid fa-trash"></a></td>
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
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/sb-admin-2.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="js/demo/datatables-demo.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
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
                                    url: 'Manage_agc.php',
                                    type: 'GET',
                                    data: 'delete=' + userId,
                                })
                                .done(function() {
                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                        icon: 'success',
                                    }).then(() => {
                                        document.location.href = 'Manage_agc.php';
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