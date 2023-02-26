<?php
    session_start();
    require_once 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Animated Login Form</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form action="Check_login.php" method="POST">
				<img src="img/avatar.svg">
				<h2>ระบบจัดการข้อมูลการเลี้ยงแพะ จังหวัดสุราษฎร์ธานี</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text" class="input" name="username" placeholder="ชื่อผู้ใช้">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="password" class="input" name="password"  placeholder="รหัสผ่าน">
            	   </div>
            	</div>
            	<a href="#">ลืมรหัสผ่าน?</a>
            	<input type="submit" class="btn" value="Login" name="btn_login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
