<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); } 
require_once dirname(__DIR__) . '/models/UserModel.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $error = "Both fields are required.";
                require dirname(__DIR__) . '/views/login.php';
                return;
            }

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            // CHANGED HERE: Direct plain text password comparison instead of password_verify()
            if ($user && $password === $user['Password']) {
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['name'] = $user['Name'];
                $_SESSION['role'] = strtolower($user['Role']);

                if ($_SESSION['role'] === 'admin') {
                    header("Location: index.php?action=admin_orders");
                } else {
                    header("Location: index.php?action=checkout");
                }
                exit();
            } else {
                $error = "Invalid Email or Password.";
                require dirname(__DIR__) . '/views/login.php';
            }
        } else {
            require dirname(__DIR__) . '/views/login.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}