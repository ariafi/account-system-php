<?php
require_once 'function/db.php';
require_once 'function/func.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = validateInput($_POST['username']);
    $email = validateInput($_POST['email']);
    $password = validateInput($_POST['pwd']);
    $passwordConfirm = validateInput($_POST['pwd2']);

    // Validate input fields
    validateFields($username, $email, $password, $passwordConfirm, $errors);

    if (empty($errors)) {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE user = :user OR email = :email");
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors[] = 'نام کاربری یا حساب الکترونیکی قبلاً وجود دارد!';
        } else {
            // Insert new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (user, email, password) VALUES (:user, :email, :pwd)");
            $stmt->bindParam(':user', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pwd', $hashedPassword);
            $stmt->execute();
            $success = 'انجام شد. اکنون به حساب خود وارد شوید!';
            $conn = null;
        }
    }
}

function validateFields(string $username, string $email, string $password, string $passwordConfirm, array &$errors): void {
    if (empty($username)) {
        $errors[] = 'نام کاربری نمیتواند خالی باشد!';
    }
    if (empty($email)) {
        $errors[] = 'حساب الکترونیکی نمیتواند خالی باشد!';
    }
    if (empty($password)) {
        $errors[] = 'رمزعبور وارد نشده است!';
    }
    if (empty($passwordConfirm)) {
        $errors[] = 'تایید رمزعبور خالی است!';
    }
    if ($password !== $passwordConfirm) {
        $errors[] = 'رمز عبور و تایید رمزعبور یکسان نیست!';
    }
}

function validateInput(string $data): string {
    return htmlspecialchars(stripslashes(trim($data)));
}

require_once 'template/header.php';
?>

<div class="box">
    <form method="post">
        <h1>ثبت نام</h1>
        <?php
        // Display success or error messages
        if (!empty($success)) {
            echo '<div class="suc"><li>' . htmlspecialchars($success, ENT_QUOTES, 'UTF-8') . '</li></div>';
        } elseif (!empty($errors)) {
            echo '<div class="err">';
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>";
            }
            echo '</div>';
        }
        ?>
        <input type="text" name="username" placeholder="نام شما" required>
        <input type="email" name="email" placeholder="حساب الکترونیکی شما" required>
        <input type="password" name="pwd" placeholder="رمز عبور شما" required>
        <input type="password" name="pwd2" placeholder="تایید رمز عبور شما" required>
        <button type="submit" name="register">ثبت نام</button>
        <a href="login.php">ورود</a>
    </form>
</div>

<?php require_once 'template/footer.php'; ?>
