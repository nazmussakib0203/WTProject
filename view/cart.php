<?php 
session_start(); 

if(!isset($_SESSION['cart_items'])){
    header('Location: ../control/cart_process.php');
    exit;
}

$items = $_SESSION['cart_items'];
$total = $_SESSION['cart_total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/mystyle.css">
    <script src="../js/myscript.js"></script>
</head>
<body>

<div class="navbar">
    <div class="logo">Book<span>store</span></div>
    <div class="nav-links">
        <a href="../control/home_process.php">Home</a>
        <a href="../control/cart_process.php">Cart</a>
    </div>
</div>

<div class="cart-container">
    <h2>Shopping Cart</h2>

    <?php if(empty($items)): ?>
        <div class="empty-cart">
            <p>Your cart is empty.</p>
            <a href="../control/home_process.php">Continue Shopping →</a>
        </div>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr id="row-<?php echo $item['cart_id']; ?>">
                    <td class="book-title"><?php echo htmlspecialchars($item['Title']); ?></td>
                    <td class="price">$<?php echo number_format($item['Price'], 2); ?></td>
                    <td>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="changeQty(<?php echo $item['cart_id']; ?>, -1)">-</button>
                            <span class="quantity-num" id="qty-<?php echo $item['cart_id']; ?>"><?php echo $item['Quantity']; ?></span>
                            <button class="quantity-btn" onclick="changeQty(<?php echo $item['cart_id']; ?>, 1)">+</button>
                        </div>
                    </td>
                    <td class="price" id="sub-<?php echo $item['cart_id']; ?>">$<?php echo number_format($item['subtotal'], 2); ?></td>
                    <td><button class="remove-btn" onclick="removeItem(<?php echo $item['cart_id']; ?>)">Remove</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            <strong>Grand Total:</strong> <span id="cart-total">$<?php echo number_format($total, 2); ?></span>
        </div>

        <div style="text-align:right;">
            <button class="checkout-btn" onclick="submitCart()">✅ Confirm Order</button>
        </div>
    <?php endif; ?>
</div>

<script src="../js/myscript.js">


updateCartCount();
</script>

</body>
</html>