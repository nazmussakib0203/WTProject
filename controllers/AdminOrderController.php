<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../models/OrderModel.php';

class AdminOrderController {

    private function checkAdminGate() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit();
        }
    }

    public function showOrders() {
        $this->checkAdminGate();
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders();
        require __DIR__ . '/../views/admin_orders.php';
    }

    // Handles inline status updates via AJAX
    public function updateStatus() {
        $this->checkAdminGate();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request operation mapped.']);
            return;
        }

        $orderId = intval($_POST['order_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        $validStatuses = ['pending', 'confirmed', 'shipped', 'delivered'];

        if ($orderId <= 0 || !in_array($status, $validStatuses)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid status options validation failure.']);
            return;
        }

        $orderModel = new OrderModel();
        if ($orderModel->updateOrderStatus($orderId, $status)) {
            echo json_encode(['status' => 'success', 'message' => 'Order status successfully modified.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save updated state details to storage records.']);
        }
    }
}