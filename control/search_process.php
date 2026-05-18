<?php
require_once '../config/db.php';
require_once '../model/mydb.php';

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();

$q = $_GET['q'] ?? '';
$filter = $_GET['filter'] ?? 'title';

$result = $mydb->searchBooks($q, $filter, $conn);

$books = [];
while($row = $result->fetch_assoc()){
    $books[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['success' => true, 'books' => $books]);

$mydb->closeConn($conn);
?>