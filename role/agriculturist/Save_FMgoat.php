<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 5){
        header("location: ../../index.php");
        exit;
    }
    require_once 'connect.php';

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `fm_data` WHERE `fm_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Save_FMgoat.php");
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

    <title>บันทึกข้อมูลพ่อ-แม่พันธุ์</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/Goat2.png"/>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="modal fade" id="AddFooodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลพ่อ-แม่พันธุ์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_fm.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">ประเภท</label>
                            <select class="form-control" aria-label="Default select example" name="type" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
                                <option value="1">พ่อพันธุ์</option>
                                <option value="2">แม่พันธุ์</option>
                            </select>
                        </div>                    
                        <div class="mb-3">
                            <label class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" name="name" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">สายพันธุ์</label>
                            <select class="form-control" aria-label="Default select example" name="gb" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `g_breed`");
                                    $stmt->execute();
                                    $gbs = $stmt->fetchAll();
                                    
                                    foreach($gbs as $gb){
                                ?>
                                <option value="<?= $gb['gb_id']?>"><?= $gb['gb_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-blue">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="wrapper">
        <?php include('sidebar.php'); ?><!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('Topbar.php'); ?><!-- Topbar -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <h3 class="m-0 font-weight-bold text-primary">บันทึกข้อมูลพ่อ-แม่พันธุ์</h3>
                        </div>
                        <!-- <div class="row mt-4">
                            <div class="col text-center">
                                <label style="color:red;" >**** ในกรณีบันทึกข้อมูลครั้งแรก ให้ระบุกลุ่มแพะให้ครบทุกประเภท ****</label>
                            </div>
                        </div> -->
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลพ่อ-แม่พันธุ์</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr align="center">
                                            <th>ลำดับที่</th>
                                            <th>ประเภท</th>
                                            <th>ชื่อ</th>
                                            <th>สายพันธุ์</th>
                                            <th>แก้ไขรายการ</th>
                                            <th>ลบรายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $id = $_SESSION['id'] ;

                                            $stmt = $db->query("SELECT fm_data.fm_id , fm_data.fm_type , fm_data.fm_name , g_breed.gb_name
                                                                FROM `fm_data`
                                                                INNER JOIN `g_breed` ON fm_data.gb_id = g_breed.gb_id
                                                                INNER JOIN `agriculturist` ON agriculturist.agc_id = fm_data.agc_id
                                                                INNER JOIN `user_login` ON agriculturist.agc_id = user_login.agc_id
                                                                WHERE user_login.user_id = '$id'");
                                            $stmt->execute();
                                            $fms = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$fms) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่มีพบข้อมูล</td></p>";
                                            } else {
                                            foreach($fms as $fm)  {  
                                        ?>
                                        <tr align="center">
                                            <th scope="row"><?= $count ;?> </th>
                                            <td>
                                                <?php 
                                                    if($fm['fm_type']==1){
                                                        echo "พ่อพันธุ์";
                                                    }else{
                                                        echo "แม่พันธุ์";
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $fm['fm_name']; ?></td>
                                            <td><?= $fm['gb_name']; ?></td>
                                            <td><a href="Edit_fm.php?edit_id=<?= $fm['fm_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                            <td><a data-id="<?= $fm['fm_id']; ?>" href="?delete=<?= $fm['fm_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid fa-trash"></i></a></td>
                                        </tr>
                                        <?php $count++ ;?> 
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
                                url: 'Save_FMgoat.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Save_FMgoat.php';
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