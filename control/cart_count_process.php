<?php
error_reporting(0);
ob_clean();
header('Content-Type: application/json');

require_once '../model/mydb.php';
session_start();

if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
}

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();
$uid = $_SESSION['user_id'];

$res = $conn->query("SELECT SUM(Quantity) as total FROM cart WHERE UserID=$uid");
$row = $res->fetch_assoc();
$count = $row['total'] ?? 0;

echo json_encode(['count'=>$count]);
$conn->close();
exit;
?>