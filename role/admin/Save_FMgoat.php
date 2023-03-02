<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `nbg_data` WHERE `nbg_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Save_feeding.php");
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

    <title>บันทึกข้อมูลการให้อาหาร</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/png" href="img/seedling-solid.svg" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-2">
                                <div class="card-header py-3 text-center">
                                    <h3 class="m-0 font-weight-bold text-primary">บันทึกข้อมูลการให้อาหาร</h3>
                                </div>
                                <div class="card-body">
                                    <!-- <div class="row mb-2">
                                        <div class="col text-center">
                                            <img loading="lazy" width="150px" style="border-radius: 200px;" src="img/VM.png" alt="">
                                        </div>
                                    </div> -->
                                    <form action="Chack_Add_nbg.php" method="POST">
                                        <div class="row mb-4">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-2">
                                                <label class="form-label">พ่อพันธุ์</label>
                                                <select class="form-control" aria-label="Default select example" name="FB" style="border-radius: 30px;" required>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <?php 
                                                        $stmt = $db->query("SELECT * FROM `fm_data` WHERE `fm_type` = '1'");
                                                        $stmt->execute();
                                                        $fms = $stmt->fetchAll();
                                                        
                                                        foreach($fms as $fm){
                                                    ?>
                                                    <option value="<?= $fm['fm_id']?>"><?= $fm['fm_name']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">แม่พันธุ์</label>
                                                <select class="form-control" aria-label="Default select example"name="MB" style="border-radius: 30px;" required>
                                                    <option selected>กรุณาเลือก....</option>
                                                    <?php 
                                                        $stmt = $db->query("SELECT * FROM `fm_data` WHERE `fm_type` = '2'");
                                                        $stmt->execute();
                                                        $fms = $stmt->fetchAll();
                                                        
                                                        foreach($fms as $fm){
                                                    ?>
                                                    <option value="<?= $fm['fm_id']?>"><?= $fm['fm_name']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">จำนวนแพะที่เกิด</label>
                                                <input type="text" class="form-control" name="quantity" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">จำนวนเพศผู้</label>
                                                <input type="text" class="form-control" name="g_male" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">จำนวนเพศเมีย</label>
                                                <input type="text" class="form-control" name="g_female" style="border-radius: 30px;" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="submit">บันทึกข้อมูล</button>
                                                &nbsp&nbsp&nbsp
                                                <button class="btn btn-danger" style="border-radius: 30px;" type="submit"">ยกเลิก</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>รหัสการเกิดแพะ</th>
                                            <th>พ่อพัน</th>
                                            <th>แม่พันธุ์</th>
                                            <th>จำนวนแพะที่เกิด</th>
                                            <th>จำนวนเพศผู้</th>
                                            <th>จำนวนเพศเมีย</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `nbg_data`");
                                            $stmt->execute();
                                            $nbgs = $stmt->fetchAll();

                                            if (!$nbgs) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($nbgs as $nbg)  {  
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $nbg['nbg_id']; ?></th>
                                            <td><?= $nbg['nbg_Fg']; ?></td>
                                            <td><?= $nbg['nbg_Mg']; ?></td>
                                            <td><?= $nbg['nbg_quantity']; ?></td>
                                            <td><?= $nbg['nbg_male']; ?></td>
                                            <td><?= $nbg['nbg_female']; ?></td>
                                            <td><a href="Edit_nbg.php?edit_id=<?= $nbg['nbg_id']; ?>" class="btn btn-warning" name="edit_id">Edit</a></td>
                                            <td><a data-id="<?= $nbg['nbg_id']; ?>" href="?delete=<?= $nbg['nbg_id']; ?>" class="btn btn-danger delete-btn">Delete</a></td>
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

    <!-- Scroll to Top Button-->
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
                                url: 'Save_feeding.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Save_feeding.php';
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