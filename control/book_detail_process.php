<?php
require_once '../model/mydb.php';
session_start();

$id = $_GET['id'];
$mydb = new MyDBFunctions();
$conn = $mydb->createConn();
$result = $mydb->getBookById($id, $conn);
$book = $result->fetch_assoc();
$mydb->closeConn($conn);

$_SESSION['book'] = $book;
header('Location: ../view/book_detail.php');
?>