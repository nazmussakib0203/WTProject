<?php
include_once("../config/db.php");
include_once("../model/usermodel.php");

$mydb = new MyDB();
$conn = $mydb->createConn();
$result = getUserList($conn);

if($result->num_rows > 0) {
    foreach($result as $user) {
        echo "<tr>";
        echo "<td>" . $user['ID'] . "</td>";
        echo "<td>" . $user['Name'] . "</td>";
        echo "<td>" . $user['Email'] . "</td>";
        echo "<td>" . $user['Role'] . "</td>";
        echo "<td><img src='../public/uploads/users/" . $user['ProfilePicture'] . "' alt='Profile Picture' width='100'></td>";
        echo "<td>" . $user['Address'] . "</td>";
        echo "<td>" . $user['Phone'] . "</td>";
        echo "<td>" . $user['CreatedAt'] . "</td>";
        echo "</tr>";
    }
}
?>