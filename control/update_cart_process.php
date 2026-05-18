<?php
require_once '../config/db.php';
require_once '../model/mydb.php';
require_once 'cart_helper.php';

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();

$userId = getUserId();
$cartId = $_POST['cart_id'];
$quantity = $_POST['quantity'];

$mydb->updateCart($cartId, $userId, $quantity, $conn);

$itemsResult = $mydb->getCartItems($userId, $conn);
$total = $mydb->getCartTotal($userId, $conn);
$cartCount = $mydb->getCartCount($userId, $conn);

$subtotal = 0;
while($item = $itemsResult->fetch_assoc()){
    if($item['cart_id'] == $cartId){
        $subtotal = $item['Price'] * $quantity;
        break;
    }
}

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'subtotal' => $subtotal,
    'cart_total' => $total,
    'cart_count' => $cartCount
]);

$mydb->closeConn($conn);
?>