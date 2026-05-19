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

<script>
function updateCartCount() {
    fetch('../control/cart_count_process.php')
        .then(res => res.json())
        .then(data => {
            let span = document.getElementById('cart-count');
            if(span) span.innerText = data.count;
        })
        .catch(err => console.error('Error:', err));
}

function changeQty(cartId, change) {
    let qtyElement = document.getElementById('qty-' + cartId);
    if (!qtyElement) return;
    
    let currentQty = parseInt(qtyElement.innerText);
    let newQty = currentQty + change;
    
    if(newQty < 1) {
        removeItem(cartId);
    } else {
        updateQty(cartId, newQty);
    }
}

function updateQty(cartId, newQty) {
    fetch('../control/update_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId + '&quantity=' + newQty
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('qty-' + cartId).innerText = newQty;
            document.getElementById('sub-' + cartId).innerHTML = '$' + data.subtotal.toFixed(2);
            document.getElementById('cart-total').innerHTML = '$' + data.cart_total.toFixed(2);
            updateCartCount();
        }
    })
    .catch(err => console.error('Error:', err));
}

function removeItem(cartId) {
    if(confirm('Remove this item?')) {
        fetch('../control/remove_cart_process.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'cart_id=' + cartId
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let row = document.getElementById('row-' + cartId);
                if(row) row.remove();
                document.getElementById('cart-total').innerHTML = '$' + data.cart_total.toFixed(2);
                updateCartCount();
                if(data.cart_total == 0) location.reload();
            }
        })
        .catch(err => console.error('Error:', err));
    }
}

function submitCart() {
    let total = document.getElementById('cart-total').innerText;
    alert('Order placed successfully!\nTotal: ' + total + '\nThank you for shopping!');
}

updateCartCount();
</script>

</body>
</html>