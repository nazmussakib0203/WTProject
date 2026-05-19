<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $new_qty = (int)$_POST['quantity'];
    
    $subtotal = 0;
    $cart_total = 0;
    $found = false;

    if (isset($_SESSION['cart_items'])) {
        foreach ($_SESSION['cart_items'] as &$item) {
            if ($item['cart_id'] == $cart_id) {
                $item['Quantity'] = $new_qty;
                $item['subtotal'] = $item['Price'] * $new_qty; // subtotal calculate
                $subtotal = $item['subtotal'];
                $found = true;
            }
            $cart_total += $item['subtotal']; // net total recap
        }
        unset($item); // reference break
        
        $_SESSION['cart_total'] = $cart_total;
    }

    if ($found) {
        echo json_encode([
            'success' => true,
            'subtotal' => $subtotal,
            'cart_total' => $cart_total
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Item not found']);
    }
    exit;
}
echo json_encode(['success' => false, 'error' => 'Invalid Request']);