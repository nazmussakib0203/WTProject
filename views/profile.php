<?php
session_start();
require_once '../config/db.php';
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="form-container" style="width: 450px;">
        <h2>Update Profile</h2>
        <?php if(isset($_GET['success'])) echo "<p style='color:green; font-weight:bold;'>✓ Profile Updated Successfully!</p>"; ?>
        <?php if(isset($_GET['error'])) echo "<p style='color:red; font-weight:bold;'>".$_GET['error']."</p>"; ?>

        <form action="../controllers/ProfileController.php" method="POST" enctype="multipart/form-data">
            <div style="margin-bottom:15px;">
                <img src="../public/uploads/profiles/<?php echo $user['profile_picture'] ?: 'default.png'; ?>" style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #00ccff;">
                <input type="file" name="profile_pic" style="font-size:12px; border:none; margin-top:10px;">
            </div>

            <label>Name</label><input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            <label>Email</label><input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <label>Phone</label><input type="text" name="phone" value="<?php echo $user['phone']; ?>">
            <label>Address</label><textarea name="address"><?php echo $user['address']; ?></textarea>
            
            <hr>
            <label>Current Password (Required)</label>
            <input type="password" name="current_password" required>
            <label>New Password (Optional)</label>
            <input type="password" name="new_password" placeholder="Leave blank to stay the same">

            <button type="submit" name="update_profile">Save Changes</button>
        </form>
    </div>
</body>
</html>