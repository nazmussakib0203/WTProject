<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $cart_total = 0;

    if (isset($_SESSION['cart_items'])) {
        foreach ($_SESSION['cart_items'] as $key => $item) {
            if ($item['cart_id'] == $cart_id) {
                unset($_SESSION['cart_items'][$key]); // item dropped
            } else {
                $cart_total += $item['subtotal'];
            }
        }
        // Array index key reset kora reconstruct er jonno
        $_SESSION['cart_items'] = array_values($_SESSION['cart_items']);
        $_SESSION['cart_total'] = $cart_total;
    }

    echo json_encode([
        'success' => true,
        'cart_total' => $cart_total
    ]);
    exit;
}
echo json_encode(['success' => false]);