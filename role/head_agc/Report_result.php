<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_POST['submit'])) {
        $topic = $_POST["topic"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
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
    <div id="wrapper">
        <?php include('sidebar.php'); ?><!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('Topbar.php'); ?><!-- Topbar -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <h3 class="m-0 font-weight-bold text-primary">สรุปผลรายงาน</h3>
                        </div>
                        <div class="col mt-4 text-right mr-6">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>  ออกรายงาน  </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>รหัสการขาย</th>
                                            <th>จำนวนยอดขายแพะ</th>
                                            <th>น้ำหนักรวม</th>
                                            <th>ราคาต่อกิโลกรัม</th>
                                            <th>ราคารวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT sale.sale_id , salelist.slist_quantity , salelist.slist_weight , salelist.slist_KgPirce , salelist.slist_price 
                                                                FROM `salelist` 
                                                                INNER JOIN `sale` ON salelist.sale_id = sale.sale_id
                                                                WHERE sale.sale_date
                                                                BETWEEN '$start_date' AND '$end_date'");
                                            $stmt->execute();
                                            $vms = $stmt->fetchAll();

                                            if (!$vms) {
                                                echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                            } else {
                                            foreach($vms as $vm)  {  
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $vm['sale_id']; ?></th>
                                            <td><?= $vm['slist_quantity']; ?></td>
                                            <td><?= $vm['slist_weight']; ?></td>
                                            <td><?= $vm['slist_KgPirce']; ?></td>
                                            <td><?= $vm['slist_price']; ?></td>
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
    </script>

</body>

</html>