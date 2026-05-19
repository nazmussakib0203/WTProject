<html>
    <head>
        <title>Purchase History</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <body>
        <h1>Purchase History</h1>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Book Title</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Order Date</th>
            </tr>
            <tbody>
                <?php include_once("../control/purchase_history_process.php"); ?>
            </tbody>
        </table>

</html>