<?php
require_once 'function/db.php';
require_once 'function/func.php';

session_start(); // Start the session

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $email = validateInput($_POST['email']);
    $password = validateInput($_POST['pwd']);

    // Validate input fields
    if (empty($email)) {
        $errors[] = 'حساب الکترونیکی نمیتواند خالی باشد!';
    }
    if (empty($password)) {
        $errors[] = 'رمزعبور وارد نشده است!';
    } else {
        // Prepare the SQL statement to avoid SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Check if user exists
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['user'];
                $success = 'وارد شدید. اکنون صفحه را بازخوانی کنید!';
            } else {
                $errors[] = 'حساب الکترونیکی یا رمزعبور نامعتبر است!';
            }
        } else {
            $errors[] = 'حساب الکترونیکی یا رمزعبور نامعتبر است!';
        }
    }
}

/**
 * Validate and sanitize input data
 */
function validateInput(string $data): string {
    return htmlspecialchars(stripslashes(trim($data)));
}

require_once 'template/header.php'; // Include header
?>

<div class="box">
    <form method="post">
        <h1>ورود</h1>
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
        <input type="email" name="email" placeholder="حساب الکترونیکی شما" required>
        <input type="password" name="pwd" placeholder="رمز عبور شما" required>
        <button type="submit" name="register">ورود</button>
        <a href="/register.php">ثبت نام</a>
    </form>
</div>

<?php require_once 'template/footer.php'; // Include footer ?>
