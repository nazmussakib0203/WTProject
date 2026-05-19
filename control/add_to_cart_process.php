<?php
ob_clean();
header('Content-Type: application/json');

require_once '../model/mydb.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
}

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();
$uid = $_SESSION['user_id'];
$bid = $_POST['book_id'];
$qty = $_POST['quantity'];

$check = $conn->query("SELECT ID FROM cart WHERE UserID=$uid AND BookID=$bid");
if($check->num_rows > 0){
    $row = $check->fetch_assoc();
    $conn->query("UPDATE cart SET Quantity=Quantity+$qty WHERE ID={$row['ID']}");
}else{
    $conn->query("INSERT INTO cart (UserID, BookID, Quantity) VALUES ($uid, $bid, $qty)");
}

$res = $conn->query("SELECT SUM(Quantity) as total FROM cart WHERE UserID=$uid");
$row = $res->fetch_assoc();
$count = $row['total'] ?? 0;

echo '{"success":true,"cart_count":' . $count . '}';
$conn->close();
exit;
?>