<?php
include_once("../config/db.php");
include_once("../model/purchasemodel.php");

$mydb = new MyDB();
$conn = $mydb->createConn();
$result = getPurchaseHistory($conn);
if($result->num_rows > 0) {
    foreach($result as $purchase) {
        echo "<tr>";
        echo "<td>" . $purchase['Name'] . "</td>";
        echo "<td>" . $purchase['Title'] . "</td>";
        echo "<td>" . $purchase['TotalAmount'] . "</td>";
        echo "<td>" . $purchase['Status'] . "</td>";
        echo "<td>" . $purchase['PaymentMethod'] . "</td>";
        echo "<td>" . $purchase['OrderDate'] . "</td>";
        echo "</tr>";
    }
}

$result = getPurchaseHistory($conn);

// add this debug line
if($result === false){
    echo "Query error: " . $conn->error;
    exit;
}
?>