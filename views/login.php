<!DOCTYPE html>
<html>
<head>
    <title>Login - Bookstore</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if(isset($_GET['error'])) echo "<p style='color:red;'>Invalid Email/Password</p>"; ?>
        <?php if(isset($_GET['success'])) echo "<p style='color:green;'>Registration Successful!</p>"; ?>
        
        <form action="../controllers/AuthController.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <div style="text-align: left; margin-bottom: 15px; font-size: 14px;">
                <input type="checkbox" name="remember" id="remember" style="width: auto; margin-right: 5px;">
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" name="login">Login</button>
        </form>
        <p>No account? <a href="registration.php">Sign up here</a></p>
    </div>
</body>
</html>