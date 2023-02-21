<?php
    session_start();
    require_once 'connect.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Login 10</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">
	</head>
	<body class="img" style="background-image: url(images/bg2.png);">
        <section class="ftco-section">
            <div class="container">
                <span class="row justify-content-center mb-4">
					<img style="width:15%" src="images/login2.png">
				</span>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="login-wrap p-0">
                            <form action="Check_login.php" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Username" name="username"required>
                                </div>
                                <div class="form-group">
                                    <input id="password-field" type="password" class="form-control" placeholder="Password" name="password"required>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="btn_login"class="form-control btn btn-primary submit px-3">เข้าสู่ระบบ</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-100 text-md-right">
                                        <a href="forgotpassword.php" style="color: #fff">ลืมรหัสผ่าน</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	    <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
	</body>
</html>