<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Personal Purchase History</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fafafa; padding: 20px; }
        .container { max-width: 900px; background: #fff; margin: 0 auto; padding: 25px; border-radius: 6px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .badge { padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .status-pending { background: #ffeeba; color: #856404; }
        .status-confirmed { background: #b8daff; color: #004085; }
        .status-shipped { background: #c3e6cb; color: #155724; }
        .status-delivered { background: #d6d8d9; color: #1b1e21; }
        .back-link { margin-bottom: 15px; display: inline-block; color: #007bff; text-decoration: none; }
        #live-badge-notice { background: #e0f2fe; color: #0369a1; padding: 8px; border-radius: 4px; display: inline-block; font-size: 13px; margin-bottom: 10px; font-weight: bold;}
    </style>
</head>
<body>

<div class="container">
    <a href="index.php?action=checkout" class="back-link">&larr; Back to Checkout / Catalog</a>
    <h2>Your Personal Purchase History</h2>
    <div id="live-badge-notice">🔄 Live Status Connection Active (Syncing continuously via AJAX)</div>
    <hr>

    <div id="history-table-container">
        <p>Loading transaction history records...</p>
    </div>
</div>

<script>
// Format currency utility helper
function formatMoney(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}

// Function to fetch and update the order history table dynamically
function fetchLivePurchaseHistory() {
    fetch('index.php?action=get_customer_history_json')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const container = document.getElementById('history-table-container');
            
            if (data.orders.length === 0) {
                container.innerHTML = '<p>No order transactions recorded for this account profile.</p>';
                return;
            }

            let htmlOutput = `
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Purchased Books</th>
                            <th>Total Spent</th>
                            <th>Payment Via</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.orders.forEach(order => {
                htmlOutput += `
                    <tr>
                        <td>#${order.order_id}</td>
                        <td>${order.OrderDate}</td>
                        <td>${order.book_details}</td>
                        <td>${formatMoney(order.TotalAmount)}</td>
                        <td>${order.PaymentMethod}</td>
                        <td>
                            <span class="badge status-${order.Status}">
                                ${order.Status}
                            </span>
                        </td>
                    </tr>
                `;
            });

            htmlOutput += `
                    </tbody>
                </table>
            `;
            
            // Update the HTML container instantly without a full page reload
            container.innerHTML = htmlOutput;
        }
    })
    .catch(error => console.error('Error fetching live data updates:', error));
}

// Run immediately on page load
fetchLivePurchaseHistory();

// Poll the server every 3000ms (3 seconds) to pull live database changes automatically
setInterval(fetchLivePurchaseHistory, 3000);
</script>

</body>
</html>