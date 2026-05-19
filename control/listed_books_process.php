<?php
include_once '../config/db.php';
include_once '../model/bookmodel.php';
$conn = new MyDB();
$conn = $conn->createConn();

$books = getBooks($conn);

 foreach($books as $book){
    echo "<tr>";
echo "<td>" . $book['Title'] . "</td>";
echo "<td>" . $book['Author'] . "</td>";
echo "<td>" . $book['Description'] . "</td>";
echo "<td>" . $book['Price'] . "</td>";
echo "<td>" . $book['CategoryName'] . "</td>";
echo "<td><img src='../public/uploads/books/" . $book['Image'] . "' alt='Book Image' width='100'></td>";
echo "<td>" . $book['Stock'] . "</td>";
echo "<td>
          <a href='../view/edit_books.php?id=".$book['ID']."'>Edit</a>
          <a href='../control/delete_books_process.php?id=".$book['ID']."'>Delete</a>

          </td>";
echo "</tr>";
 }
?>