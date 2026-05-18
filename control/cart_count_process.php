<?php
require_once '../config/db.php';
require_once '../model/mydb.php';
require_once 'cart_helper.php';

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();

$userId = getUserId();
$count = $mydb->getCartCount($userId, $conn);

header('Content-Type: application/json');
echo json_encode(['count' => $count]);

$mydb->closeConn($conn);
?>