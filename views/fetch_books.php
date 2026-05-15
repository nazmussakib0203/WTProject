<?php
require_once '../config/db.php';
$cat_id = $_GET['cat_id'];
$res = $conn->query("SELECT * FROM books WHERE category_id = $cat_id");
$books = [];
while($row = $res->fetch_assoc()) { $books[] = $row; }
echo json_encode($books);