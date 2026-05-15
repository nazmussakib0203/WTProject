<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['register'])) {
    $email = trim($_POST['email']);
    
    // REQUIREMENT: Validate Unique Email
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        header("Location: ../views/registration.php?error=exists");
        exit();
    }

    $name = trim($_POST['name']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $addr = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role, phone, address) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $name, $email, $pass, $role, $phone, $addr);
    $stmt->execute();
    header("Location: ../views/login.php?success=1");
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($pass, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($remember) {
            $token = bin2hex(random_bytes(20));
            $hash = password_hash($token, PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET remember_token = '$hash' WHERE id = " . $user['id']);
            setcookie('remember_me', $user['id'] . ':' . $token, time() + (86400 * 30), "/");
        }
        header("Location: ../views/home.php");
    } else {
        header("Location: ../views/login.php?error=1");
    }
}
?>