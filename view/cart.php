<?php
require_once '../config/db.php';
require_once '../model/mydb.php';
require_once '../control/cart_helper.php';

$userId = getUserId();
$mydb = new MyDBFunctions();
$conn = $mydb->createConn();
$result = $mydb->getCartItems($userId, $conn);
$total = $mydb->getCartTotal($userId, $conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>

<div style="background:#333; color:white; padding:10px;">
    <a href="home.php" style="color:white;">Home</a> | 
    <a href="cart.php" style="color:white;">Cart (<span id="cart-count">0</span>)</a>
</div>

<div style="padding:20px;">
    <h2>Shopping Cart</h2>
    
    <?php if($result->num_rows == 0): ?>
        <p>Your cart is empty.</p>
        <a href="home.php">Continue Shopping</a>
    <?php else: ?>
        <table border="1" cellpadding="10" style="width:100%;">
            <tr bgcolor="#ddd">
                <th>Book</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
            <?php while($item = $result->fetch_assoc()): 
                $subtotal = $item['Price'] * $item['Quantity'];
            ?>
            <tr id="row-<?php echo $item['cart_id']; ?>">
                <td><?php echo $item['Title']; ?></td>
                <td>$<?php echo $item['Price']; ?></td>
                <td>
                    <button onclick="updateQuantity(<?php echo $item['cart_id']; ?>, <?php echo $item['Quantity']-1; ?>)">-</button>
                    <span id="qty-<?php echo $item['cart_id']; ?>"><?php echo $item['Quantity']; ?></span>
                    <button onclick="updateQuantity(<?php echo $item['cart_id']; ?>, <?php echo $item['Quantity']+1; ?>)">+</button>
                </td>
                <td id="subtotal-<?php echo $item['cart_id']; ?>">$<?php echo number_format($subtotal, 2); ?></td>
                <td><button onclick="removeItem(<?php echo $item['cart_id']; ?>)">Remove</button></td>
            </tr>
            <?php endwhile; ?>
            <tr bgcolor="#ddd">
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td colspan="2"><strong id="cart-total">$<?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </table>
        <br>
        <a href="home.php">Continue Shopping</a>
    <?php endif; ?>
</div>

<script>
function updateCartCount() {
    fetch('../control/cart_count_process.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('cart-count').innerText = data.count;
        });
}

function updateQuantity(cartId, newQuantity) {
    if(newQuantity < 1) {
        removeItem(cartId);
        return;
    }
    
    fetch('../control/update_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId + '&quantity=' + newQuantity
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('qty-' + cartId).innerText = newQuantity;
            document.getElementById('subtotal-' + cartId).innerText = '$' + parseFloat(data.subtotal).toFixed(2);
            document.getElementById('cart-total').innerText = '$' + parseFloat(data.cart_total).toFixed(2);
            updateCartCount();
        }
    });
}

function removeItem(cartId) {
    if(!confirm('Remove this item?')) return;
    
    fetch('../control/remove_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            location.reload();
        }
    });
}

updateCartCount();
</script>

</body>
</html>