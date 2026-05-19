<?php
require_once '../model/mydb.php';
session_start();

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();
$books = $mydb->getAllBooks($conn);

$allBooks = [];
while($row = $books->fetch_assoc()){
    $allBooks[] = $row;
}
$mydb->closeConn($conn);

$_SESSION['books'] = $allBooks;
header('Location: ../view/home.php');
?>