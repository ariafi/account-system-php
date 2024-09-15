<?php
require_once 'function/db.php';
session_start();
if(empty($_SESSION['user'])) {
	header('location: login.php');
}
$user = $_SESSION['user'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user = :user");
$stmt->bindParam(':user', $user);
$stmt->execute();
$fetch = $stmt->fetch();
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
		<h2>سلام <?php echo $fetch['user']; ?></h2>
		<p>نام کاربری: <b><?php echo $fetch['user']; ?></b></p>
		<p>ایمیل: <b><?php echo $fetch['email']; ?></b></p>
		<p>شناسه: <b><?php echo $fetch['id']; ?></b></p>
		<a href="logout.php">خروج</a>
	</div>
</body>
<html>