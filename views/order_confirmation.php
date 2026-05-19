<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; text-align: center; padding-top: 50px; }
        .box { background: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h1 { color: #28a745; margin-top: 0; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="box">
    <h1>Thank You for Your Order!</h1>
    <p>Your payment transaction simulation succeeded, and the order has been initialized.</p>
    <p><strong>Your Order Tracking Reference ID is: #<?= htmlspecialchars($orderId) ?></strong></p>
    <p>Status: <em>Pending Verification Review (Admin Processing)</em></p>
    
    <a href="index.php?action=history" class="btn">View Purchase History</a>
</div>

</body>
</html>