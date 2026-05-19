<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Checkout Summary</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fafafa; margin: 0; padding: 20px; }
        .container { max-width: 800px; background: #fff; margin: 0 auto; padding: 25px; border-radius: 6px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h2, h3 { color: #222; }
        .nav-links { margin-bottom: 20px; text-align: right; }
        .nav-links a { margin-left: 15px; color: #007bff; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 8px; }
        textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; height: 80px; resize: none; }
        select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-order { background: #28a745; color: white; border: none; padding: 12px 20px; font-size: 16px; border-radius: 4px; cursor: pointer; width: 100%; }
        .error-msg { color: #dc3545; font-weight: bold; margin-bottom: 15px; display: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-links">
        <span>Logged in as: <strong><?= htmlspecialchars($_SESSION['name']) ?></strong></span>
        <a href="index.php?action=history">My Purchase History</a>
        <a href="index.php?action=logout">Logout</a>
    </div>

    <h2>Order Checkout</h2>
    <hr>

    <h3>Items Summary</h3>
    <table>
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($cartItems as $item): 
                $subtotal = $item['Price'] * $item['Quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['Title']) ?></td>
                <td>$<?= number_format($item['Price'], 2) ?></td>
                <td><?= htmlspecialchars($item['Quantity']) ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Grand Total:</td>
                <td style="font-weight: bold; color: #d9534f;">$<?= number_format($total, 2) ?></td>
            </tr>
        </tbody>
    </table>

    <div class="error-msg" id="validationError"></div>

    <form id="checkoutForm">
        <div class="form-group">
            <label for="address">Delivery Address</label>
            <textarea id="address" name="address" placeholder="Enter your full shipping address details..."></textarea>
        </div>

        <div class="form-group">
            <label for="payment_method">Select Payment Method</label>
            <select id="payment_method" name="payment_method">
                <option value="">-- Choose Option --</option>
                <option value="Credit Card">Credit Card</option>
                <option value="bKash">bKash</option>
                <option value="Nagad">Nagad</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
            </select>
        </div>

        <button type="submit" class="btn-order">Finalize Order & Pay</button>
    </form>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const address = document.getElementById('address').value.trim();
    const paymentMethod = document.getElementById('payment_method').value;
    const errorDiv = document.getElementById('validationError');
    
    if (address === '' || paymentMethod === '') {
        errorDiv.textContent = 'Client Error: Both shipping address and payment method options are mandatory.';
        errorDiv.style.display = 'block';
        return;
    }
    errorDiv.style.display = 'none';

    const formData = new FormData();
    formData.append('address', address);
    formData.append('payment_method', paymentMethod);

    fetch('index.php?action=submit_checkout', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Ensure the server returned a valid response
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // Instantly transition the client to the confirmation screen using the new order ID
            window.location.href = 'index.php?action=confirmation&order_id=' + data.order_id;
        } else {
            errorDiv.textContent = 'Server Error: ' + data.message;
            errorDiv.style.display = 'block';
        }
    })
    .catch(error => {
        errorDiv.textContent = 'Connection Error: Failed to complete the transaction or parse response.';
        errorDiv.style.display = 'block';
    });
});
</script>

</body>
</html>