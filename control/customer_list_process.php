<?php
include_once("../config/db.php");
include_once("../model/usermodel.php");

$mydb = new MyDB();
$conn = $mydb->createConn();
$role = "customer";
$result = getCustomerList($role, $conn);

if($result->num_rows > 0) {
    foreach($result as $customer) {
        echo "<tr>";
        echo "<td>" . $customer['ID'] . "</td>";
        echo "<td>" . $customer['Name'] . "</td>";
        echo "<td>" . $customer['Email'] . "</td>";
        echo "<td><img src='../public/uploads/users/" . $customer['ProfilePicture'] . "' alt='Profile Picture' width='100'></td>";
        echo "<td>" . $customer['Address'] . "</td>";
        echo "<td>" . $customer['Phone'] . "</td>";
        echo "<td>" . $customer['CreationTime'] . "</td>";
        echo "<td>
            <a href='../control/remove_customer_process.php?customer_id=" . $customer['ID'] . "'>Delete</a>
            </td>";
        echo "</tr>";
    }
}
?>