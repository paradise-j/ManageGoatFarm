<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $db->query("DELETE FROM `group_g` WHERE `gg_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Manage_Ggoat.php");
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

    <title>จัดการข้อมูลกลุ่มแพะ</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/seedling-solid.svg" />
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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลกลุ่มแพะ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_add_Ggoat.php" method="POST">
                        <div class="mb-3">
                            <label for="update_type" class="col-form-label">ประเภท</label>
                            <select class="form-control" aria-label="Default select example" name="type" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกประเภท....</option>
                                <option value="1">แพะพ่อพันธุ์</option>
                                <option value="2">แพะแม่พันธุ์</option>
                                <option value="3">แพะขุน</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="update_range_age" class="col-form-label">ช่วงอายุ</label>
                            <select class="form-control" aria-label="Default select example" name="range_age" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกช่วงอายุ....</option>
                                <option value="1">1-2 ปี</option>
                                <option value="2">3-5 ปี</option>
                                <option value="3">5 ปีขึ้นไป</option>
                                <option value="4">ไม่เกิน 4 เดือน</option>
                                <option value="5">ไม่เกิน 5 เดือน</option>
                                <option value="6">ไม่เกิน 6 เดือน</option>
                                <option value="7">6 เดือนขึ้นไป</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">จำนวน</label>
                            <input type="text" required class="form-control" name="quantity" style="border-radius: 30px;" required>
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
                            <h3 class="m-0 font-weight-bold text-primary">จัดการข้อมูลกลุ่มแพะ</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลกลุ่มแพะ</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr align="center">
                                            <th>รหัสกลุ่มแพะ</th>
                                            <th>ประเภท</th>
                                            <th>ช่วงอายุ</th>
                                            <th>จำนวน</th>
                                            <!-- <th></th> -->
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `group_g`");
                                            $stmt->execute();
                                            $ggs = $stmt->fetchAll();

                                            if (!$ggs) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($ggs as $gg)  {  
                                        ?>
                                        <tr>
                                            <td scope="row"><?= $gg['gg_id']; ?></td>
                                            <td>
                                                <?php 
                                                    if($gg['gg_type'] == 1){
                                                        echo "แพะพ่อพันธุ์";
                                                    }elseif($gg['gg_type'] == 2){
                                                        echo "แพะแม่พันธุ์";
                                                    }else{
                                                        echo "แพะขุน";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($gg['gg_range_age'] == 1){
                                                        echo "1-2 ปี";
                                                    }elseif($gg['gg_range_age'] == 2){
                                                        echo "3-5 ปี";
                                                    }elseif($gg['gg_range_age'] == 3){
                                                        echo "5 ปีขึ้นไป";
                                                    }elseif($gg['gg_range_age'] == 4){
                                                        echo "ไม่เกิน 4 เดือน";
                                                    }elseif($gg['gg_range_age'] == 5){
                                                        echo "ไม่เกิน 5 เดือน";
                                                    }elseif($gg['gg_range_age'] == 6){
                                                        echo "ไม่เกิน 6 เดือน";
                                                    }else{
                                                        echo "6 เดือนขึ้นไป";
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $gg['gg_quantity']; ?></td>
                                            <!-- <td><button  type="button" class="btn btn-warning editbtn" >Edit</button></td> -->
                                            <!-- <td><a href="edit_Ggoat.php?edit_id=<?= $gg['gg_id'];?>" class="btn btn-warning" data-toggle="modal" data-target="#EditGgoatModal">Edit</a></td> -->
                                            <td>
                                                <a href="edit_Ggoat.php?edit_id=<?= $gg['gg_id'];?>" class="btn btn-warning" name="edit_id"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a data-id="<?= $gg['gg_id']; ?>" href="?delete=<?= $gg['gg_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                            <!-- <td></td> -->
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
                                url: 'Manage_Ggoat.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Manage_Ggoat.php';
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

    </script>
</body>

</html>