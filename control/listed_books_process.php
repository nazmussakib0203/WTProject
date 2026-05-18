<?php
require_once '../config/db.php';
require_once '../model/bookmodel.php';
$conn = new MyDB();
$conn = $conn->createConn();

$books = getBooks($conn);

 foreach($books as $book){
    echo "<tr>";
echo "<td>" . $book['Title'] . "</td>";
echo "<td>" . $book['Author'] . "</td>";
echo "<td>" . $book['Price'] . "</td>";
echo "<td>" . $book['Stock'] . "</td>";
echo "</tr>";
 }
?>