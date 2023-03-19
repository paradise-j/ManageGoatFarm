<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $Fname = $_POST['Fname'];
        $position = $_POST['position'];
        $Gname = $_POST['Gname'];
        $personid = $_POST['personid'];
        $phone = $_POST['phone'];
        $edu = $_POST['edu'];
        $exper = $_POST['exper'];
        $obj = $_POST['obj'];
        $type = $_POST['type'];
        $img = $_FILES['img'];

            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt; 
            $filePath = 'uploads/'.$fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($img['size'] > 0 && $img['error'] == 0) {
                    if (move_uploaded_file($img['tmp_name'], $filePath)) {
                        $sql = $db->prepare("INSERT INTO `agriculturist`( 
                                                                         `agc_name`, 
                                                                         `agc_nfarm`, 
                                                                         `agc_gfarm`, 
                                                                         `agc_position_G`, 
                                                                         `agc_personid`, 
                                                                         `agc_phone`, 
                                                                         `agc_exper`, 
                                                                         `agc_edu`, 
                                                                         `agc_obj`, 
                                                                         `agc_type`, 
                                                                         `agc_img`) VALUES (:name, 
                                                                                            :Fname, 
                                                                                            :Gname, 
                                                                                            :position, 
                                                                                            :personid, 
                                                                                            :phone, 
                                                                                            :edu, 
                                                                                            :exper, 
                                                                                            :obj,
                                                                                            :type, 
                                                                                            :img)");
                        $sql->bindParam(":name", $name);
                        $sql->bindParam(":Fname", $Fname);
                        $sql->bindParam(":position", $position);
                        $sql->bindParam(":Gname", $Gname);
                        $sql->bindParam(":personid", $personid);
                        $sql->bindParam(":phone", $phone);
                        $sql->bindParam(":edu", $edu);
                        $sql->bindParam(":exper", $exper);
                        $sql->bindParam(":obj", $position);
                        $sql->bindParam(":type", $type);
                        $sql->bindParam(":img", $fileNew);
                        $sql->execute();

                        if ($sql) {
                            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
                            echo "<script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        title: 'success',
                                        text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                                        icon: 'success',
                                        timer: 5000,
                                        showConfirmButton: false
                                    });
                                })
                            </script>";
                            header("refresh:1; url=Manage_agc.php");
                        } else {
                            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                            header("location: Manage_agc.php");
                        }
                    }
                }
            }
    }
?>