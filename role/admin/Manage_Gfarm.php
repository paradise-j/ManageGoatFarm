<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `gf_data` WHERE `gf_id` = '$delete_id'");
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

    <title>จัดการข้อมูลกลุ่มเลี้ยง</title>

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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลกลุ่มเลี้ยง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_add_vm.php" method="POST">
                        <!-- <div class="mb-3">
                            <label for="firstname" class="col-form-label">ประเภท</label>
                            <select class="form-control" aria-label="Default select example" id="typevm" name="typevm" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
                                <option value="1">ยา</option>
                                <option value="2">วัคซีน</option>
                            </select>
                        </div> -->
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ชื่อกลุ่ม</label>
                            <input type="text" required class="form-control" name="namevm" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">จังหวัด</label>
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
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">อำเภอ</label>
                            <select class="form-control" aria-label="Default select example" id="amphures" name="amphures" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกอำเภอ....</option>
                                <!-- <option value="1">ยา</option>
                                <option value="2">วัคซีน</option> -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ตำบล</label>
                            <select class="form-control" aria-label="Default select example" id="districts" name="districts" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกตำบล....</option>
                                <!-- <option value="1">ยา</option>
                                <option value="2">วัคซีน</option> -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">รหัสไปรษณีย์</label>
                            <input type="text" required class="form-control" id="zipcode" name="zipcode" style="border-radius: 30px;">
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
                            <h3 class="m-0 font-weight-bold text-primary">จัดการข้อมูลกลุ่มเลี้ยง</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลกลุ่มเลี้ยง</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>รหัสกลุ่มเลี้ยง</th>
                                            <th>ชื่อกลุ่มเลี้ยง</th>
                                            <th>ตำบล</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `group_farm`");
                                            $stmt->execute();
                                            $gfs = $stmt->fetchAll();

                                            if (!$gfs) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($gfs as $gf)  {  
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $gf['gf_id']; ?></th>
                                            <td><?= $gf['gf_name']; ?></td>
                                            <td><?= $gf['gf_subdis']; ?></td>
                                            <td><?= $gf['gf_dis']; ?></td>
                                            <td><?= $gf['gf_province']; ?></td>
                                            <td><a href="Edit_gf.php?edit_id=<?= $gf['gf_id']; ?>" class="btn btn-warning" name="edit_id">Edit</a></td>
                                            <td><a data-id="<?= $gf['gf_id']; ?>" href="?delete=<?= $gf['gf_id']; ?>" class="btn btn-danger delete-btn">Delete</a></td>
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
                    // console.log(data)
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

</body>

</html>