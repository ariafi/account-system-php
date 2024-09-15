<?php
require_once 'function/db.php';
require_once 'function/func.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['register'])) {
		$user = vd($_POST['username']);
		$email = vd($_POST['email']);
		$pwd = vd($_POST['pwd']);
		$pwd2 = vd($_POST['pwd2']);
		
		if(empty($user)) {
			array_push($err, 'نام کاربری نمیتواند خالی باشد!');
		} 
		if(empty($email)) {
			array_push($err, 'حساب الکترونیکی نمیتواند خالی باشد!');
		}
		if(empty($pwd)) {  
			array_push($err, 'رمزعبور وارد نشده است!');  
		}  
		if(empty($pwd2)) {  
			array_push($err, 'تایید رمزعبور خالی است!');  
		}
		if(!empty($pwd) && !empty($pwd2) && $pwd != $pwd2) {  
			array_push($err, 'رمز عبور و تایید رمزعبور یکسان نیست!');  
		}
		$stmt = $conn->prepare("SELECT * FROM users WHERE user = :user OR email = :email");
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			array_push($err, 'نام کاربری یا حساب الکترونیکی قبلاً وجود دارد!');
		} else {
			if (count($err) == 0) {
				$suc = 'انجام شد. اکنون به حساب خود وارد شوید!';
				$pswd = md5($pwd);
				$stmt = $conn->prepare("INSERT INTO users (user, email, password) values (:user, :email, :pwd)");
				$stmt->bindParam(':user', $user);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':pwd', $pswd);
				$stmt->execute();
				$conn = null;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account System</title>
  <link rel="stylesheet" href="assets/style.css" />
</head>
<body>
	<div class="box">
		<form method="post">
			<h1>ثبت نام</h1>
			<?php
			if(isset($suc)) {
				echo '<div class="suc">';
				echo "<li>$suc</li>";
				echo '</div>';
			} else if(!empty($err)) {
				echo '<div class="err">';
				foreach ($err as $er) :
					echo "<li>$er</li>";
				endforeach;
				echo '</div>';
			}
			?>
			<input type="text" name="username" placeholder="نام شما">
			<input type="email" name="email" placeholder="حساب الکترونیکی شما">
			<input type="password" name="pwd" placeholder="رمز عبور شما">
			<input type="password" name="pwd2" placeholder="تایید رمز عبور شما">
			<button type="submit" name="register">ثبت نام</button>
			<a href="login.php">ورود</a>
		</form>
	</div>
</body>
<html>