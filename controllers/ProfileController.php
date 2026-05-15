<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['update_profile'])) {
    $uid = $_SESSION['user_id'];
    $email = trim($_POST['email']);
    $curr_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];

    $stmt = $conn->prepare("SELECT password_hash, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!password_verify($curr_pass, $user['password_hash'])) {
        header("Location: ../views/profile.php?error=Current password incorrect");
        exit();
    }

    $email_check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $email_check->bind_param("si", $email, $uid);
    $email_check->execute();
    if ($email_check->get_result()->num_rows > 0) {
        header("Location: ../views/profile.php?error=Email already in use");
        exit();
    }

    $img = $user['profile_picture'];
    if (!empty($_FILES['profile_pic']['name'])) {
        $img = time() . "_" . $_FILES['profile_pic']['name'];
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "../public/uploads/profiles/" . $img);
    }

    $final_pass = $user['password_hash'];
    if (!empty($new_pass)) { $final_pass = password_hash($new_pass, PASSWORD_DEFAULT); }

    $name = $_POST['name']; $phone = $_POST['phone']; $addr = $_POST['address'];
    $upd = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, address=?, profile_picture=?, password_hash=? WHERE id=?");
    $upd->bind_param("ssssssi", $name, $email, $phone, $addr, $img, $final_pass, $uid);
    
    if ($upd->execute()) {
        $_SESSION['name'] = $name;
        header("Location: ../views/profile.php?success=1");
    }
}
?>