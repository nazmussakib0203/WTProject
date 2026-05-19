<?php
include_once("../control/admin_dashboard_process.php");
?>
<html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <body>
        <div class="dashboard">
            <div class="card">
                <h2>Total Books</h2>
                <p><?php echo $totalBooks; ?></p>
            </div>
            <div class="card">
                <h2>Total Customers</h2>
                <p><?php echo $totalCustomers; ?></p>
            </div>
            <div class="card">
                <h2>Total Orders</h2>
                <p><?php echo $totalOrders; ?></p>
            </div>
            <div class="card">
                <h2>Total Revenue</h2>
                <p><?php echo $totalRevenue; ?></p>
            </div>
        </div>
    </body>
</html>