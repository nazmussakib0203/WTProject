<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

class CheckoutController {
    
    // Protection Gate wrapper verification
    private function checkCustomerGate() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
            header("Location: index.php?action=login");
            exit();
        }
    }

    public function showCheckoutPage() {
        $this->checkCustomerGate();
        $cartModel = new CartModel();
        $cartItems = $cartModel->getCartItemsByUserId($_SESSION['user_id']);
        require __DIR__ . '/../views/checkout.php';
    }

    // Handles checkout submission via AJAX
    public function submitCheckout() {
        $this->checkCustomerGate();
        header('Content-Type: application/json'); // Return formatted API responses JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid Request Method']);
            return;
        }

        $address = trim($_POST['address'] ?? '');
        $paymentMethod = trim($_POST['payment_method'] ?? '');

        // Server-Side Validation Check
        if (empty($address) || empty($paymentMethod)) {
            echo json_encode(['status' => 'error', 'message' => 'Please provide a valid delivery address and select a payment method.']);
            return;
        }

        $cartModel = new CartModel();
        $orderModel = new OrderModel();
        $userId = $_SESSION['user_id'];

        $cartItems = $cartModel->getCartItemsByUserId($userId);
        if (empty($cartItems)) {
            echo json_encode(['status' => 'error', 'message' => 'Your active shopping cart is empty.']);
            return;
        }

        // Calculate order total
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['Price'] * $item['Quantity'];
        }

        try {
            // Place order and clear cart via database transaction
            $orderId = $orderModel->placeOrder($userId, $totalAmount, $paymentMethod, $cartItems);
            $cartModel->clearCartByUserId($userId);

            echo json_encode(['status' => 'success', 'order_id' => $orderId]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function showConfirmation() {
        $this->checkCustomerGate();
        $orderId = $_GET['order_id'] ?? 0;
        require __DIR__ . '/../views/order_confirmation.php';
    }

    public function showPurchaseHistory() {
        $this->checkCustomerGate();
        $orderModel = new OrderModel();
        $orders = $orderModel->getCustomerPurchaseHistory($_SESSION['user_id']);
        require __DIR__ . '/../views/purchase_history.php';
    }

    public function getHistoryJSON() {
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit();
        }
        $orderModel = new OrderModel();
        $orders = $orderModel->getCustomerPurchaseHistory($_SESSION['user_id']);
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'orders' => $orders]);
        exit();
    }
}