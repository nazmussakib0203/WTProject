<?php
ob_clean();
header('Content-Type: application/json');

require_once '../model/mydb.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();

$q = $_GET['q'] ?? '';
$filter = $_GET['filter'] ?? 'title';

if($filter == 'title'){
    $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID=c.ID WHERE b.Title LIKE '%$q%'";
}elseif($filter == 'author'){
    $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID=c.ID WHERE b.Author LIKE '%$q%'";
}else{
    $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID=c.ID WHERE c.Name LIKE '%$q%'";
}

$result = $conn->query($sql);
$books = [];
while($row = $result->fetch_assoc()){
    $books[] = $row;
}

echo '{"success":true,"books":' . json_encode($books) . '}';
$conn->close();
exit;
?>