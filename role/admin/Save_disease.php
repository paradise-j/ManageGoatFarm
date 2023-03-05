<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `gvc_data` WHERE `gvc_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Save_GVM.php");
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

    <title>บันทึกข้อมูลการเป็นโรคของแพะ</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/Vaccine.png"/>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/datepicker.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="modal fade" id="AddFooodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการเป็นโรคของแพะ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_Gdis.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">ชื่อโรค</label>
                            <select class="form-control" aria-label="Default select example"name="VMname" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `gdis_data`");
                                    $stmt->execute();
                                    $gdiss = $stmt->fetchAll();
                                    
                                    foreach($gdiss as $gdis){
                                ?>
                                <option value="<?= $gdis['gdis_id']?>"><?= $gdis['gdis_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ระดับความรุนแรง</label>
                            <input type="text" class="form-control" name="quantity" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">วันที่พบโรค</label>
                            <!-- <input type="text" class="form-control" name="price" style="border-radius: 30px;" required> -->
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' style="border-radius: 30px;" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer"> 
                            <button class="btn btn-danger" style="border-radius: 30px;" type="submit"">ยกเลิก</button>
                            <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="submit">บันทึกข้อมูล</button>
                            
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
                            <h3 class="m-0 font-weight-bold text-primary">บันทึกข้อมูลการเป็นโรคของแพะ</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลการเป็นโรคของแพะ</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>รหัสการเป็นโรคของแพะ</th>
                                            <th>ชื่อโรค</th>
                                            <th>ระดับความรุนแรง</th>
                                            <th>วันที่พบโรค</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT gvc_data.gvc_id , group_g.gg_type , group_g.gg_range_age , gvc_data.gvc_type , vc_data.vc_name , gvc_data.gvc_quantity , gvc_data.gvc_price , gvc_data.gvc_month 
                                                                FROM `gvc_data` 
                                                                INNER JOIN `group_g` ON gvc_data.gg_id = group_g.gg_id 
                                                                INNER JOIN `vc_data` ON gvc_data.vc_id = vc_data.vc_id ");
                                            $stmt->execute();
                                            $vms = $stmt->fetchAll();

                                            if (!$vms) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($vms as $vm)  {  
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $vm['gvc_id']; ?></th>
                                            <td>
                                                <?php 
                                                    if($vm['gg_type'] == 1){
                                                        echo "แพะพ่อพันธุ์";
                                                    }elseif($vm['gg_type'] == 2){
                                                        echo "แพะแม่พันธุ์";
                                                    }else{
                                                        echo "แพะขุน";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($vm['gg_range_age'] == 1){
                                                        echo "1-2 ปี";
                                                    }elseif($vm['gg_range_age'] == 2){
                                                        echo "3-5 ปี";
                                                    }elseif($vm['gg_range_age'] == 3){
                                                        echo "5 ปีขึ้นไป";
                                                    }elseif($vm['gg_range_age'] == 4){
                                                        echo "ไม่เกิน 4 เดือน";
                                                    }elseif($vm['gg_range_age'] == 5){
                                                        echo "ไม่เกิน 5 เดือน";
                                                    }elseif($vm['gg_range_age'] == 6){
                                                        echo "ไม่เกิน 6 เดือน";
                                                    }else{
                                                        echo "6 เดือนขึ้นไป";
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $vm['gvc_type']; ?></td>
                                            <td><a href="Edit_vm.php?edit_id=<?= $vm['gvc_id']; ?>" class="btn btn-warning" name="edit_id">Edit</a></td>
                                            <td><a data-id="<?= $vm['gvc_id']; ?>" href="?delete=<?= $vm['gvc_id']; ?>" class="btn btn-danger delete-btn">Delete</a></td>
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
    <script src="js/datepicker.js"></script>

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
                                url: 'Save_GVM.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Save_GVM.php';
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

        $(function () {
            $('#datetimepicker1').datetimepicker();
        });
    </script>

</body>

</html>