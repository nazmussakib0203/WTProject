<?php
session_start();
require_once '../config/db.php';

// Clear token from DB
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

// Clear Session
session_unset();
session_destroy();

// Clear Cookie
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

header("Location: ../views/login.php");
exit();
?>