<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 5){
        header("location: ../../index.php");
        exit;
    }
    require_once 'connect.php';

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        // echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `gvc_data` WHERE `gvc_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว');</script>";
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

    <title>บันทึกข้อมูลการให้ยาและวัคซีน</title>

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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการให้ยาและวัคซีน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_GVM.php" method="POST">
                        <div class="mb-3">
                            <label for="inputState" class="form-label">วันที่ให้ยาและวัคซีน</label>
                            <input type="date" style="border-radius: 30px;" name="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_type" class="col-form-label">ประเภทแพะ</label>
                            <select class="form-control" aria-label="Default select example" id="type" name="type" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกประเภท....</option>
                                <option value="1">พ่อพันธุ์</option>
                                <option value="2">แม่พันธุ์</option>
                                <option value="3">แพะขุน</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">ช่วงอายุแพะ</label>
                            <select class="form-control" aria-label="Default select example" id="range_age" name="range_age" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกช่วงอายุ....</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ประเภท</label>
                            <select class="form-control" aria-label="Default select example" id="VMtype" name="VMtype" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
                                <option value="1">ให้ยา</option>
                                <option value="2">ให้วัคซีน</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ชื่อผลิตภัณฑ์</label>
                            <select class="form-control" aria-label="Default select example" id="VMname" name="VMname" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือกผลิตภัณฑ์....</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ปริมาณยาหรือวัคซีน</label>
                            <input type="number" class="form-control" name="quantity" style="border-radius: 30px;" required>
                        </div>
                        <div class="col text-center">
                            <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="submit">บันทึกข้อมูล</button>
                            &nbsp&nbsp&nbsp
                            <button class="btn btn-danger" style="border-radius: 30px;" type="submit"">ยกเลิก</button>
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
                            <h3 class="m-0 font-weight-bold text-primary">บันทึกข้อมูลการให้ยาและวัคซีน</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลการให้ยาและวัคซีน</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr align="center">
                                            <th>ลำดับที่</th>
                                            <th>ประเภท</th>
                                            <th>ช่วงอายุ</th>
                                            <th>ประเภทการให้</th>
                                            <th>ชื่อผลิตภัณฑ์</th>
                                            <th>ปริมาณ</th>
                                            <th>เดือนที่ให้</th>
                                            <!-- <th>แก้ไขรายการ</th> -->
                                            <th>ลบรายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $id = $_SESSION['id'] ;
                                            $stmt = $db->query("SELECT `gvc_id` , group_g.gg_type , group_g.gg_range_age , `gvc_type` , vc_data.vc_name , `gvc_quantity` ,  `gvc_date`
                                                                FROM `gvc_data` 
                                                                INNER JOIN `group_g` ON gvc_data.gg_id = group_g.gg_id 
                                                                INNER JOIN `vc_data` ON gvc_data.vc_id = vc_data.vc_id
                                                                INNER JOIN `agriculturist` ON agriculturist.agc_id = group_g.agc_id
                                                                INNER JOIN `user_login` ON agriculturist.agc_id = user_login.agc_id
                                                                WHERE user_login.user_id = '$id'");
                                            $stmt->execute();
                                            $vms = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$vms) {
                                                echo "<p><td colspan='8' class='text-center'>ลบข้อมูลเรียบร้อยแล้ว</td></p>";
                                            } else {
                                            foreach($vms as $vm)  {  
                                        ?>
                                        <tr align="center">
                                            <th scope="row"><?= $count; ?></th>
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
                                                        echo "ไม่เกิน 3 เดือน";
                                                    }elseif($vm['gg_range_age'] == 5){
                                                        echo "3-4 เดือน";
                                                    }elseif($vm['gg_range_age'] == 6){
                                                        echo "4-5 เดือน";
                                                    }else{
                                                        echo "5 เดือนขึ้นไป";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($vm['gvc_type'] == 1) {
                                                        echo "ให้ยา";
                                                    }else{
                                                        echo "ให้วัคซีน";
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $vm['vc_name']; ?></td>
                                            <td><?= $vm['gvc_quantity']; ?></td>
                                            <td class="date_th"><?= $vm['gvc_date']; ?></td>
                                            <!-- <td><a href="Edit_vm.php?edit_id=<?= $vm['gvc_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid fa-pen-to-square"></i></a></td> -->
                                            <td><a data-id="<?= $vm['gvc_id']; ?>" href="?delete=<?= $vm['gvc_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid fa-trash"></i></a></td>
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

        const dom_date = document.querySelectorAll('.date_th')
        dom_date.forEach((elem)=>{
            const my_date = elem.textContent
            const date = new Date(my_date)

            const result = date.toLocaleDateString('th-TH', {

            year: 'numeric',

            month: 'long',

            day: 'numeric',

            }) 
            elem.textContent=result
        })

        $('#type').change(function(){
            var id_provnce = $(this).val();
            $.ajax({
                type : "post",
                url : "gg.php",
                data : {id:id_provnce,function:'type'},
                success: function(data){
                    $('#range_age').html(data);
                }
            });
        });

        $('#VMtype').change(function(){
            var id_VMtype = $(this).val();
            $.ajax({
                type : "post",
                url : "vm.php",
                data : {id:id_VMtype,function:'VMtype'},
                success: function(data){
                    // console.log(data)
                    $('#VMname').html(data);
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