<?php
require_once dirname(__DIR__) . '/config/Database.php';

class CartModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getCartItemsByUserId($userId) {
        
        $sql = "SELECT c.ID as cart_id, c.Quantity, b.ID as book_id, b.Title, b.Price, b.Stock 
                FROM cart c 
                JOIN books b ON c.BookID = b.ID 
                WHERE c.UserID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function clearCartByUserId($userId) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE UserID = ?");
        return $stmt->execute([$userId]);
    }
}