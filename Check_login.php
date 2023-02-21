<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_POST['btn_login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        try {
            $select_stmt = $db->prepare("SELECT * FROM `user_login` WHERE `user_name` = :uusername AND `user_password` = :upassword");
            $select_stmt->bindParam(":uusername", $username);
            $select_stmt->bindParam(":upassword", $password);
            $select_stmt->execute(); 

            while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $dbusername = $row['user_name'];
                $dbpassword = $row['user_password'];
                $dbrole = $row['user_role'];
            }
            echo $username;
            echo $password;
            echo $role;

            if ($username != null AND $password != null) {
                if ($select_stmt->rowCount() > 0) {
                    if ($username == $dbusername AND $password == $dbpassword ) {
                        switch($dbrole) {
                            case '1':
                                $_SESSION['admin_login'] = $username;
                                $_SESSION['success'] = "Admin... Successfully Login...";
                                header("location: role/admin/index.php");
                            break;
                            // case '2':
                            //     $_SESSION['director_login'] = $email;
                            //     $_SESSION['success'] = "director... Successfully Login...";
                            //     header("location: director/index.php");
                            // break;
                            // case '3':
                            //     $_SESSION['user_login'] = $email;
                            //     $_SESSION['success'] = "User... Successfully Login...";
                            //     header("location: user/index.php");
                            // break;
                            default:
                                $_SESSION['error'] = "Wrong email or password or role";
                                header("location: agriculturist/index.php");
                        }
                    }
                } else {
                    $_SESSION['error'] = "Wrong email or password or role";
                    header("location: index.php");
                }
            }
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }
?>