<nav class="nav-container">
    <div>
        <a href="home.php" class="home-btn">🏠 Home</a>
        <a href="profile.php" class="profile-btn-pop">Profile</a>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <a href="admin_panel.php" style="color: #f1c40f; text-decoration: none; font-weight: bold; margin-left: 15px;">Admin Panel</a>
        <?php endif; ?>
    </div>
    
    <div style="color: white; font-size: 14px;">
        <span>Hi, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong> (<?php echo ucfirst($_SESSION['role']); ?>)</span>
        <a href="../controllers/LogoutController.php" style="margin-left: 20px; color: #ff4757; text-decoration: none; font-weight: bold;">Logout</a>
    </div>
</nav>