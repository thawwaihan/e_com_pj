<?php

session_start();
require_once "../database/db.php";
$pageCurrent=basename($_SERVER['PHP_SELF']);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    $_SESSION['login_error'] = "Please enter email and password.";
    header("Location: login.php");
    exit;
}


$sql = "SELECT id, name, email, password, role
        FROM users
        WHERE email = :email
        LIMIT 1";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['login_error'] = "Email or password is incorrect.";
    exit;
}


if (!password_verify($password, $user['password'])) {
    $_SESSION['login_error'] = "Email or password is incorrect.";
    header("Location: login.php");
    exit;
}


session_regenerate_id(true);

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['role'] = $user['role'];

if ($user['role'] === 'admin') {

    header("Location: ../admin/dashboard.php");
    exit;

}

if ($user['role'] === 'user') {

    header("Location: ../pages/index.php");
    exit;

}


session_destroy();

$_SESSION['login_error'] = "Invalid account role.";
header("Location: login.php");
exit;
