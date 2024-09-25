<?php
require_once 'function/db.php';
session_start();

// Redirect to login if user is not logged in
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data
$user = $_SESSION['user'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user = :user");
$stmt->bindParam(':user', $user);
$stmt->execute();
$fetch = $stmt->fetch();

// Redirect to login if user is not found
if (!$fetch) {
    header('Location: login.php');
    exit();
}

require_once 'template/header.php';
?>

<div class="box">
    <h2>سلام <?php echo htmlspecialchars($fetch['user'], ENT_QUOTES, 'UTF-8'); ?></h2>
    <p>نام کاربری: <b><?php echo htmlspecialchars($fetch['user'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <p>ایمیل: <b><?php echo htmlspecialchars($fetch['email'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <p>شناسه: <b><?php echo htmlspecialchars($fetch['id'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <a href="logout.php">خروج</a>
</div>

<?php
require_once 'template/footer.php';
?>
