<?php
session_start();

if (isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    header('Location: dashboard.php');
    exit();
}

$errors = [];

function validateData(string $data): string {
    return htmlspecialchars(stripslashes(trim($data)));
}

?>
