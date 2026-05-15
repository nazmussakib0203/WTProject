<?php
session_start();
require_once '../config/db.php';

// Check for Remember Me Cookie if session is not set
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    list($user_id, $token) = explode(':', $_COOKIE['remember_me']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // Verify the token from cookie against hashed token in DB
    if ($user && $user['remember_token'] && password_verify($token, $user['remember_token'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];
    }
}

// Security Redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Bookstore</title>
    <link rel="stylesheet" href="../public/style.css">
    <script src="../public/validation.js" defer></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div style="background:#fff; padding:20px; border-radius:15px;">
        <h3>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h3>
        <p>Browse books by category:</p>
        
        <div style="margin-bottom:20px;">
            <?php
            $cats = mysqli_query($conn, "SELECT * FROM categories");
            while($c = mysqli_fetch_assoc($cats)) {
                echo "<button style='width:auto; margin-right:10px;' onclick='loadBooks({$c['id']})'>{$c['name']}</button>";
            }
            ?>
        </div>
        
        <div class="book-grid" id="book-display">
            <p>Select a category to start browsing.</p>
        </div>
    </div>
</body>
</html>