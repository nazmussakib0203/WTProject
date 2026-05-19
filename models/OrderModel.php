<?php
require_once dirname(__DIR__) . '/config/Database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function placeOrder($userId, $totalAmount, $paymentMethod, $cartItems) {
        try {
            $this->db->beginTransaction();

            // Explicitly matches your exact schema: ID, UserID, TotalAmount, Status, PaymentMethod, OrderDate
            $orderSql = "INSERT INTO orders (UserID, TotalAmount, Status, PaymentMethod, OrderDate) VALUES (?, ?, 'pending', ?, CURDATE())";
            $stmt = $this->db->prepare($orderSql);
            $stmt->execute([$userId, $totalAmount, $paymentMethod]);
            $orderId = $this->db->lastInsertId();

            // Insert into order_items matching exact column names
            $itemSql = "INSERT INTO order_items (OrderID, BookID, Quantity, UnitPrice) VALUES (?, ?, ?, ?)";
            $itemStmt = $this->db->prepare($itemSql);

            // Deduct from book stock records
            $updateStockSql = "UPDATE books SET Stock = Stock - ? WHERE ID = ?";
            $stockStmt = $this->db->prepare($updateStockSql);

            foreach ($cartItems as $item) {
                if ($item['Quantity'] > $item['Stock']) {
                    throw new Exception("Inadequate stock available for book: " . $item['Title']);
                }
                $itemStmt->execute([$orderId, $item['book_id'], $item['Quantity'], $item['Price']]);
                $stockStmt->execute([$item['Quantity'], $item['book_id']]);
            }

            // Insert into payments matching exact column names
            $txId = ($paymentMethod === 'Cash on Delivery') ? null : 'TXN-' . strtoupper(uniqid());
            $paySql = "INSERT INTO payments (OrderID, Amount, PaymentMethod, TransactionID, PaymentDate) VALUES (?, ?, ?, ?, CURDATE())";
            $payStmt = $this->db->prepare($paySql);
            $payStmt->execute([$orderId, $totalAmount, $paymentMethod, $txId]);

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getCustomerPurchaseHistory($userId) {
        $sql = "SELECT o.ID as order_id, o.TotalAmount, o.Status, o.PaymentMethod, o.OrderDate,
                       GROUP_CONCAT(CONCAT(b.Title, ' (x', oi.Quantity, ')') SEPARATOR ', ') as book_details
                FROM orders o
                JOIN order_items oi ON o.ID = oi.OrderID
                JOIN books b ON oi.BookID = b.ID
                WHERE o.UserID = ?
                GROUP BY o.ID
                ORDER BY o.ID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAllOrders() {
        $sql = "SELECT o.ID as order_id, u.Name as customer_name, o.TotalAmount, o.Status, o.PaymentMethod, o.OrderDate,
                       GROUP_CONCAT(CONCAT(b.Title, ' (x', oi.Quantity, ')') SEPARATOR ', ') as book_details
                FROM orders o
                JOIN users u ON o.UserID = u.ID
                JOIN order_items oi ON o.ID = oi.OrderID
                JOIN books b ON oi.BookID = b.ID
                GROUP BY o.ID
                ORDER BY o.ID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateOrderStatus($orderId, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET Status = ? WHERE ID = ?");
        return $stmt->execute([$status, $orderId]);
    }
}