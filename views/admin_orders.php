<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal - Order Processing Management</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f5; padding: 20px; }
        .container { max-width: 1100px; background: #fff; margin: 0 auto; padding: 25px; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header-bar { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f1f3f5; color: #495057; }
        select { padding: 6px; border-radius: 4px; border: 1px solid #ccc; font-size: 13px; }
        .btn-update { padding: 6px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; }
        .badge { padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .status-pending { background: #ffeeba; color: #856404; }
        .status-confirmed { background: #b8daff; color: #004085; }
        .status-shipped { background: #c3e6cb; color: #155724; }
        .status-delivered { background: #d6d8d9; color: #1b1e21; }
        .toast { display: none; background: #28a745; color: white; padding: 10px 20px; position: fixed; top: 20px; right: 20px; border-radius: 4px; z-index: 1000; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    </style>
</head>
<body>

<div class="toast" id="toastNotice"></div>

<div class="container">
    <div class="header-bar">
        <h2>Admin Order Processing Panel</h2>
        <div>
            <span>Welcome Admin, <strong><?= htmlspecialchars($_SESSION['name']) ?></strong></span> | 
            <a href="index.php?action=logout" style="color:#dc3545; text-decoration:none;">Logout</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Books Summary</th>
                <th>Total Invoice</th>
                <th>Current Status</th>
                <th>Action Status Control</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr id="row-<?= $order['order_id'] ?>">
                <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                <td><strong><?= htmlspecialchars($order['customer_name']) ?></strong></td>
                <td><?= htmlspecialchars($order['OrderDate']) ?></td>
                <td><?= htmlspecialchars($order['book_details']) ?></td>
                <td>$<?= number_format($order['TotalAmount'], 2) ?></td>
                <td>
                    <span id="badge-<?= $order['order_id'] ?>" class="badge status-<?= htmlspecialchars($order['Status']) ?>">
                        <?= htmlspecialchars($order['Status']) ?>
                    </span>
                </td>
                <td>
                    <select id="status-<?= $order['order_id'] ?>">
                        <option value="pending" <?= $order['Status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= $order['Status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="shipped" <?= $order['Status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $order['Status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                    </select>
                    <button class="btn-update" onclick="updateOrderStatus(<?= $order['order_id'] ?>)">Update</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function updateOrderStatus(orderId) {
    const statusSelect = document.getElementById('status-' + orderId);
    const statusValue = statusSelect.value;
    const toast = document.getElementById('toastNotice');
    const badge = document.getElementById('badge-' + orderId);
    const targetRow = document.getElementById('row-' + orderId);

    const formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('status', statusValue);

    fetch('index.php?action=admin_update_status', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            toast.textContent = data.message;
            toast.style.backgroundColor = '#28a745';
            toast.style.display = 'block';
            
            // CRITICAL AJAX LIVE FIX: Dynamically rewrite DOM classes without any reload
            badge.textContent = statusValue;
            badge.className = 'badge status-' + statusValue;
            
            // Highlight row to indicate operational completion success
            const origBg = targetRow.style.backgroundColor;
            targetRow.style.backgroundColor = '#e2f0d9';
            setTimeout(() => { 
                toast.style.display = 'none'; 
                targetRow.style.backgroundColor = origBg;
            }, 1500);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => alert('Communication network error.'));
}
</script>
</body>
</html>