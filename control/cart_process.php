<?php
require_once '../model/mydb.php';
session_start();

if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
}

$uid = $_SESSION['user_id'];
$mydb = new MyDBFunctions();
$conn = $mydb->createConn();

$sql = "SELECT c.ID as cart_id, c.Quantity, b.Title, b.Price 
        FROM cart c 
        JOIN books b ON c.BookID = b.ID 
        WHERE c.UserID = $uid";
$result = $conn->query($sql);

$cartItems = [];
$total = 0;

while($row = $result->fetch_assoc()){
    $price = (float)$row['Price'];
    $qty = (int)$row['Quantity'];
    $subtotal = $price * $qty;
    $total = $total + $subtotal;
    
    $cartItems[] = [
        'cart_id' => $row['cart_id'],
        'Title' => $row['Title'],
        'Price' => $price,
        'Quantity' => $qty,
        'subtotal' => $subtotal
    ];
}

$mydb->closeConn($conn);

$_SESSION['cart_items'] = $cartItems;
$_SESSION['cart_total'] = $total;

header('Location: ../view/cart.php');
exit;
?>