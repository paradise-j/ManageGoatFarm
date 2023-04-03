<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
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

        $stmt = $db->query("SELECT `gf_id` FROM `group_farm` 
                            WHERE `gf_name` = '$Gname' ");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        // echo $gf_id;


            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt; 
            $filePath = 'uploads/'.$fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($img['size'] > 0 && $img['error'] == 0) {
                    if (move_uploaded_file($img['tmp_name'], $filePath)) {
                        $sql = $db->prepare("UPDATE `agriculturist` SET  `agc_name`= :name, 
                                                                         `agc_nfarm`= :Fname, 
                                                                         `agc_position_G`= :position, 
                                                                         `agc_personid`= :personid, 
                                                                         `agc_phone`= :phone, 
                                                                         `agc_exper`= :exper, 
                                                                         `agc_edu`= :edu, 
                                                                         `agc_obj`= :obj, 
                                                                         `agc_type`= :type,
                                                                         `gf_id`= :gf_id,
                                                                         `agc_img` = :img WHERE `agc_id` = :id");
                        
                        $sql->bindParam(":id", $id);
                        $sql->bindParam(":name", $name);
                        $sql->bindParam(":Fname", $Fname);
                        $sql->bindParam(":position", $position);
                        $sql->bindParam(":personid", $personid);
                        $sql->bindParam(":phone", $phone);
                        $sql->bindParam(":edu", $edu);
                        $sql->bindParam(":exper", $exper);
                        $sql->bindParam(":obj", $position);
                        $sql->bindParam(":type", $type);
                        $sql->bindParam(":gf_id", $gf_id);
                        $sql->bindParam(":img", $fileNew);
                        $sql->execute();

                        if ($sql) {
                            $_SESSION['success'] = "แก้ไขข้อมูลเรียบร้อยแล้ว";
                            echo "<script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                                        icon: 'success',
                                        timer: 5000,
                                        showConfirmButton: false
                                    });
                                })
                            </script>";
                            header("refresh:1; url=Manage_agc.php");
                        } else {
                            $_SESSION['error'] = "แก้ไขข้อมูลเรียบร้อยไม่สำเร็จ";
                            header("location: Manage_agc.php");
                        }
                    }
                }
            }
    }
?>