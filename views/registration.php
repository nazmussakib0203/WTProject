<!DOCTYPE html>
<html>
<head>
    <title>Register - Bookstore</title>
    <link rel="stylesheet" href="../public/style.css">
    <script>
        function validateReg() {
            let p = document.getElementById("pass").value;
            if(p.length < 8) { alert("Password must be at least 8 characters!"); return false; }
            return true;
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h2>Create Account</h2>
        <?php if(isset($_GET['error'])) echo "<p style='color:red;'>Email already exists!</p>"; ?>
        <form action="../controllers/AuthController.php" method="POST" onsubmit="return validateReg()">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" id="pass" placeholder="Password (Min 8 chars)" required>
            
            <input type="text" name="phone" placeholder="Phone Number" required>
            
            <label>Address</label>
            <textarea name="address" placeholder="Your full address here..." required></textarea>
            
            <label>Select Role</label>
            <select name="role">
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="register">Sign Up</button>
        </form>
        <p style="margin-top:15px;">Already a member? <a href="login.php">Login</a></p>
    </div>
</body>
</html>