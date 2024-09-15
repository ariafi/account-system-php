<?php
require_once 'function/db.php';
require_once 'function/func.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['register'])) {
		$email = vd($_POST['email']);
		$pwd = vd($_POST['pwd']);
		
		if(empty($email)) {
			array_push($err, 'حساب الکترونیکی نمیتواند خالی باشد!');
		} 
		if(empty($pwd)) {
			array_push($err, 'رمزعبور وارد نشده است!');
		} else {
			$pswd = md5($pwd);
			$stmt = $conn->prepare("SELECT * FROM users WHERE email =? AND password =?");
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':pwd', $pwd);
			$stmt->execute(array($email, $pswd));
			$row = $stmt->rowCount();
			$fetch = $stmt->fetch();
			if($stmt->rowCount() > 0) {
				$_SESSION['user'] = $fetch['user'];
				$suc = 'وارد شدید. اکنون صفحه را بازخوانی کنید!';
			} else {
				array_push($err, 'حساب الکترونیکی یا رمزعبور نامعتبر است!');
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
			<h1>ورود</h1>
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
			<input type="email" name="email" placeholder="حساب الکترونیکی شما">
			<input type="password" name="pwd" placeholder="رمز عبور شما">
			<button type="submit" name="register">ورود</button>
			<a href="./">ثبت نام</a>
		</form>
	</div>
</body>
<html>