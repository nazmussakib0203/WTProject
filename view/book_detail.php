<?php 
session_start(); 

if(!isset($_SESSION['books'])){
    header('Location: ../control/home_process.php');
    exit;
}

$bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$book = null;

foreach ($_SESSION['books'] as $b) {
    if ((int)$b['ID'] === $bookId) {
        $book = $b;
        break;
    }
}

if(!$book) {
    echo "<div style='text-align:center; padding:50px;'><h2>Book details not found!</h2><a href='../control/home_process.php'>Back to Store</a></div>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($book['Title']); ?> - Details</title>
    <link rel="stylesheet" href="/Bookstore/css/mystyle.css">
    <script src="/Bookstore/js/myscript.js" defer></script>
</head>
<body>

<div class="navbar">
    <div class="logo">Book<span>store</span></div>
    <div class="nav-links">
        <a href="../control/home_process.php">Home</a> | 
        <a href="../control/cart_process.php">Cart (<span id="cart-count">0</span>)</a>
    </div>
</div>

<div style="max-width:600px; margin:30px auto; background:white; padding:30px; border-radius:8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
    <h2><?php echo htmlspecialchars($book['Title']); ?></h2><br>
    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['Author']); ?></p>
    <p><strong>Genre:</strong> <?php echo htmlspecialchars($book['cat_name'] ?? 'General'); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($book['Description']); ?></p>
    <p style="color:#e74c3c; font-size:18px; margin:10px 0;"><strong>Price:</strong> $<?php echo number_format($book['Price'], 2); ?></p>
    <p><strong>Stock Status:</strong> <?php echo ($book['Stock'] > 0) ? $book['Stock']." items left" : "<span style='color:red;'>Out of stock</span>"; ?></p>

    <?php if($book['Stock'] > 0): ?>
        <div style="margin-top:20px;">
            Quantity: <input type="number" id="qty" value="1" min="1" max="<?php echo $book['Stock']; ?>" style="width:50px; padding:5px; text-align:center;">
            <button onclick="addToCart(<?php echo $book['ID']; ?>)" style="padding:6px 15px; background:#2ecc71; color:white; border:none; border-radius:4px; cursor:pointer;">Add to Cart</button>
        </div>
    <?php endif; ?>

    <div id="msg" style="margin-top:15px; min-height:20px;"></div>
    <br>
    <a href="../control/home_process.php" style="color:#667eea; text-decoration:none; font-weight:bold;">← Back to Catalog</a>
</div>

</body>
</html>