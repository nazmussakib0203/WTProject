<?php
require_once '../config/db.php';
require_once '../model/mydb.php';
require_once 'cart_helper.php';

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();

$userId = getUserId();
$cartId = $_POST['cart_id'];

$mydb->removeFromCart($cartId, $userId, $conn);

$total = $mydb->getCartTotal($userId, $conn);
$cartCount = $mydb->getCartCount($userId, $conn);

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'cart_total' => $total,
    'cart_count' => $cartCount
]);

$mydb->closeConn($conn);
?>