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
        $deletestmt = $db->query("DELETE FROM `gfg_data` WHERE `gfg_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Save_Gfeed.php");
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

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/Vaccine.png"/>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="modal fade" id="AddFooodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการให้อาหาร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_seeding.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">ประเภทแพะ</label>
                            <select class="form-control" aria-label="Default select example"name="type" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
                                <option value="1">แพะพ่อพันธุ์</option>
                                <option value="2">แพะแม่พันธุ์</option>
                                <option value="3">แพะขุน</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ช่วงอายุ</label>
                            <select class="form-control" aria-label="Default select example" name="range_age" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
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
                            <label class="form-label">ประเภทอาหาร</label>
                            <input type="text" class="form-control" name="amount" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ปริมาณอาหาร</label>
                            <input type="text" class="form-control" name="amount" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ราคาต่อกิโลกรัม</label>
                            <input type="text" class="form-control" name="priceKG" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputState" class="form-label">วันที่ให้อาหาร</label>
                            <input type="date" style="border-radius: 30px;" name="date" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-blue" style="border-radius: 30px;" type="submit" name="submit">บันทึกข้อมูล</button>
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
                            <h3 class="m-0 font-weight-bold text-primary">บันทึกข้อมูลการให้อาหาร</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลการให้อาหาร</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>รหัสการให้อาหาร</th>
                                            <th>ประเภท</th>
                                            <th>ช่วงอายุ</th>
                                            <th>ประเภทอาหาร</th>
                                            <th>ปริมาณอาหาร</th>
                                            <th>ราคา</th>
                                            <th>วันที่ให้</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT gfg_data.gfg_id , group_g.gg_type , group_g.gg_range_age , fg_data.fg_type , gfg_data.gfg_quantity , gfg_data.gfg_price , gfg_data.gfg_date
                                                                FROM `gfg_data` 
                                                                INNER JOIN `group_g` ON group_g.gg_id = gfg_data.gg_id
                                                                INNER JOIN `fg_data` ON fg_data.fg_id = gfg_data.fg_id ");
                                            $stmt->execute();
                                            $gfgs = $stmt->fetchAll();

                                            if (!$gfgs) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($gfgs as $gfg)  {  
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $gfg['gfg_id']; ?></th>
                                            <td>
                                                <?php 
                                                    if($gfg['gg_type'] == 1){
                                                        echo "แพะพ่อพันธุ์";
                                                    }elseif($gfg['gg_type'] == 2){
                                                        echo "แพะแม่พันธุ์";
                                                    }else{
                                                        echo "แพะขุน";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($gfg['gg_range_age'] == 1){
                                                        echo "1-2 ปี";
                                                    }elseif($gfg['gg_range_age'] == 2){
                                                        echo "3-5 ปี";
                                                    }elseif($gfg['gg_range_age'] == 3){
                                                        echo "5 ปีขึ้นไป";
                                                    }elseif($gfg['gg_range_age'] == 4){
                                                        echo "ไม่เกิน 4 เดือน";
                                                    }elseif($gfg['gg_range_age'] == 5){
                                                        echo "ไม่เกิน 5 เดือน";
                                                    }elseif($gfg['gg_range_age'] == 6){
                                                        echo "ไม่เกิน 6 เดือน";
                                                    }else{
                                                        echo "6 เดือนขึ้นไป";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($gfg['fg_type'] == 1 ){
                                                        echo "ธรรมชาติ";
                                                    }elseif($gfg['fg_type'] == 1 ){
                                                        echo "ข้น";
                                                    }else{
                                                        echo "TMR";
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $gfg['gfg_quantity']; ?></td>
                                            <td><?= $gfg['gfg_price']; ?></td>
                                            <td class="date_th"><?= $gfg['gfg_date']; ?></td>
                                            <td><a href="Edit_gfg.php?edit_id=<?= $gfg['gfg_id']; ?>" class="btn btn-warning" name="edit_id">Edit</a></td>
                                            <td><a data-id="<?= $gfg['gfg_id']; ?>" href="?delete=<?= $gfg['gfg_id']; ?>" class="btn btn-danger delete-btn">Delete</a></td>
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
    <script src="js/datepicker.th.min.js"></script>

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
                                url: 'Save_Gfeed.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Save_Gfeed.php';
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
    </script>

</body>

</html>