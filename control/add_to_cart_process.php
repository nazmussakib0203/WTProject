<?php
require_once '../config/db.php';
require_once '../model/mydb.php';
require_once 'cart_helper.php';

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();

$userId = getUserId();
$bookId = $_POST['book_id'];
$quantity = $_POST['quantity'];

$stockCheck = $mydb->checkStock($bookId, $quantity, $conn);

if(!$stockCheck){
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Insufficient stock']);
    exit;
}

$mydb->addToCart($userId, $bookId, $quantity, $conn);
$cartCount = $mydb->getCartCount($userId, $conn);

header('Content-Type: application/json');
echo json_encode(['success' => true, 'cart_count' => $cartCount]);

$mydb->closeConn($conn);
?>