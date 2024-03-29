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
        $deletestmt = $db->query("DELETE FROM `vc_data` WHERE `vc_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Manage_vm.php");
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

    <title>จัดการข้อมูลยาและวัคซีน</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/Vaccine.png"/>
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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลยาและวัคซีน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_add_vm.php" method="POST">
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ประเภทการให้</label>
                            <select class="form-control" aria-label="Default select example" id="type" name="type" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือก....</option>
                                <option value="1">ยา</option>
                                <option value="2">วัคซีน</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ชื่อผลิตภัณฑ์</label>
                            <!-- <input type="text" required class="form-control" name="namevm" style="border-radius: 30px;"> -->
                            <select class="form-control" aria-label="Default select example" id="namevm" name="namevm" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือกชื่อผลิตภัณฑ์....</option>
                                <option value="1">ยา</option>
                                <option value="2">วัคซีน</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">รายละเอียด</label>
                            <textarea type="text"  class="form-control" name="descripvm" id="descripvm" rows="5" style="border-radius: 20px;"></textarea>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="firstname" class="col-form-label">ส่วนประกอบ</label>
                            <textarea type="text"  class="form-control" name="descripvm" id="descripvm" rows="5" style="border-radius: 20px;" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">วิธีการใช้</label>
                            <textarea type="text"  class="form-control" name="descripvm" id="descripvm" rows="5" style="border-radius: 20px;" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ปริมาณการฉีด</label>
                            <textarea type="text"  class="form-control" name="descripvm" id="descripvm" rows="5" style="border-radius: 20px;" required></textarea>
                        </div> -->
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
                            <h3 class="m-0 font-weight-bold text-primary">จัดการข้อมูลยาและวัคซีน</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลยาและวัคซีน</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr align="center">
                                            <th>ลำดับที่</th>
                                            <th>ประเภทการให้</th>
                                            <th>ชื่อผลิตภัณฑ์</th>
                                            <th>รายละเอียด</th>
                                            <th>แก้ไขรายการ</th>
                                            <th>ลบรายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `vc_data`");
                                            $stmt->execute();
                                            $vcs = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$vcs) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($vcs as $vc)  {  
                                        ?>
                                        <tr align="center">
                                            <th scope="row"><?= $count; ?></th>
                                            <td>
                                                <?php 
                                                    if($vc['vc_type'] == 1){
                                                        echo "ยา";
                                                    }else{
                                                        echo "วัคซีน";
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $vc['vc_name']; ?></td>
                                            <td><?= $vc['vc_descrip']; ?></td>
                                            <td><a href="Edit_vc.php?edit_id=<?= $vc['vc_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                            <td><a data-id="<?= $vc['vc_id']; ?>" href="?delete=<?= $vc['vc_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid fa-trash"></i></a></td>
                                        </tr>
                                        <?php $count++; ?>
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
                                url: 'Manage_vm.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Manage_vm.php';
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

        $('#type').change(function(){
            var id_type = $(this).val();
            // console.log(id_type)
            $.ajax({
                type : "post",
                url : "M_vm.php",
                data : {id:id_type,function:'type'},
                success: function(data){
                    console.log(data);
                    $('#namevm').html(data);
                }
            });
        });


        $('#namevm').change(function(){
            var id_namevm = $(this).val();
            $.ajax({
                type : "post",
                url : "M_vm.php",
                data : {id:id_namevm,function:'namevm'},
                success: function(data){
                    // console.log(data);
                    $('#descripvm').html(data);
                }
            });
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