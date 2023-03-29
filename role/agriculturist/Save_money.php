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
        $deletestmt = $db->query("DELETE FROM `money_inex` WHERE `money_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=Save_money.php");
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

    <title>บันทึกข้อมูลรายรับ-รายจ่าย</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="img/money-bill-transfer-solid.svg"/>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/datepicker.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" 
    integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="modal fade" id="AddFooodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลรายรับ-รายจ่าย</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_money.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">วันที่พบโรค</label>
                            <input type="date" style="border-radius: 30px;" name="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ประเภท</label>
                            <select class="form-control" aria-label="Default select example" id="typemoney" name="typemoney" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือก....</option>
                                <option value="1">รายได้แฝง</option>
                                <option value="2">รายจ่าย</option>
                                <option value="3">ประหยัดค่าใช้จ่าย</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รายการ</label>
                            <select class="form-control" aria-label="Default select example" id="list" name="list" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกรายการ....</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">จำนวนเงิน</label>
                            <input type="number" style="border-radius: 30px;" name="quan" class="form-control" required>
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
                            <h3 class="m-0 font-weight-bold text-primary">บันทึกข้อมูลรายรับ-รายจ่าย</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-blue" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddFooodModal">เพิ่มข้อมูลรายรับ-รายจ่าย</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr align="center">
                                            <th>ลำดับที่</th>
                                            <th>วันที่ทำรายการ</th>
                                            <th>ประเภท</th>
                                            <th>รายการ</th>
                                            <th>จำนวนเงิน</th>
                                            <th>เกษตรกร</th>
                                            <th>แก้ไขรายการ</th>
                                            <th>ลบรายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT `money_id`,`money_type`,`money_list`,`money_quan`,`money_date`,agriculturist.agc_name
                                                                FROM `money_inex` 
                                                                INNER JOIN `agriculturist` ON agriculturist.agc_id = money_inex.agc_id");
                                            $stmt->execute();
                                            $moneys = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$moneys) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($moneys as $money)  {  
                                        ?>
                                        <tr align="center">
                                            <th scope="row"><?= $count; ?></th>
                                            <td class="date_th"><?= $money['money_date']; ?></td>
                                            <td>
                                                <?php 
                                                    if($money['money_type'] == 1){
                                                        echo "รายรับ";
                                                    }else{
                                                        echo "รายจ่าย";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($money['money_type'] == 1 ){
                                                        if ($money['money_list'] == 1){
                                                            echo "ขายมูลแพะ";
                                                        }
                                                    }elseif($money['money_type'] == 2){
                                                        if($money['money_list'] == 1) {
                                                            echo "ค่ายา";
                                                        }elseif($money['money_list'] == 2){
                                                            echo "ค่าวัคซีน";
                                                        }elseif($money['money_list'] == 3){
                                                            echo "ค่าอาหาร";
                                                        }
                                                    }else{
                                                        if($money['money_list'] == 1) {
                                                            echo "ค่าน้ำมันตัดหญ้า";
                                                        }else{
                                                            echo "ค่าปุ๋ย";
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $money['money_quan']; ?></td>
                                            <td><?= $money['agc_name']; ?></td>
                                            <td><a href="Edit_vm.php?edit_id=<?= $money['money_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                            <td><a data-id="<?= $money['money_id']; ?>" href="?delete=<?= $money['money_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid fa-trash"></i></a></td>
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
                                url: 'Save_money.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Save_money.php';
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


        $('#typemoney').change(function(){
            var id_money = $(this).val();
            console.log(id_money)
            $.ajax({
                type : "post",
                url : "money.php",
                data : {id:id_money,function:'typemoney'},
                success: function(data){
                    // console.log(data);
                    $('#list').html(data);
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