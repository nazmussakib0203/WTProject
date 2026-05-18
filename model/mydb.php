<?php
require_once __DIR__ . '/../config/db.php';

class MyDBFunctions extends MyDB {
    
    // ========== BOOK FUNCTIONS ==========
    function getAllBooks($conn){
        $sql = "SELECT b.*, c.Name as cat_name 
                FROM books b 
                LEFT JOIN categories c ON b.`Category ID` = c.ID";
        return $conn->query($sql);
    }
    
    function searchBooks($keyword, $filter, $conn){
        if($filter == 'title') {
            $sql = "SELECT b.*, c.Name as cat_name FROM books b 
                    LEFT JOIN categories c ON b.`Category ID` = c.ID 
                    WHERE b.Title LIKE '%$keyword%'";
        } elseif($filter == 'author') {
            $sql = "SELECT b.*, c.Name as cat_name FROM books b 
                    LEFT JOIN categories c ON b.`Category ID` = c.ID 
                    WHERE b.Author LIKE '%$keyword%'";
        } else {
            $sql = "SELECT b.*, c.Name as cat_name FROM books b 
                    LEFT JOIN categories c ON b.`Category ID` = c.ID 
                    WHERE c.Name LIKE '%$keyword%'";
        }
        return $conn->query($sql);
    }
    
    function getBookById($id, $conn){
        $sql = "SELECT b.*, c.Name as cat_name FROM books b 
                LEFT JOIN categories c ON b.`Category ID` = c.ID 
                WHERE b.ID = $id";
        return $conn->query($sql);
    }
    
    function checkStock($bookId, $qty, $conn){
        $result = $conn->query("SELECT Stock FROM books WHERE ID = $bookId");
        $book = $result->fetch_assoc();
        return $book && $book['Stock'] >= $qty;
    }
    
    // ========== CART FUNCTIONS ==========
    function addToCart($userId, $bookId, $qty, $conn){
        $check = $conn->query("SELECT ID, Quantity FROM cart 
                               WHERE `User ID` = $userId AND `Book ID` = $bookId");
        
        if($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $newQty = $row['Quantity'] + $qty;
            return $conn->query("UPDATE cart SET Quantity = $newQty WHERE ID = {$row['ID']}");
        } else {
            return $conn->query("INSERT INTO cart (`User ID`, `Book ID`, Quantity) 
                                VALUES ($userId, $bookId, $qty)");
        }
    }
    
    function getCartItems($userId, $conn){
        $sql = "SELECT c.ID as cart_id, c.Quantity, b.ID as book_id, 
                b.Title, b.Price, b.Stock, b.Image 
                FROM cart c 
                JOIN books b ON c.`Book ID` = b.ID 
                WHERE c.`User ID` = $userId";
        return $conn->query($sql);
    }
    
    function getCartCount($userId, $conn){
        $result = $conn->query("SELECT SUM(Quantity) as total 
                                FROM cart WHERE `User ID` = $userId");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    
    function getCartTotal($userId, $conn){
        $result = $conn->query("SELECT SUM(b.Price * c.Quantity) as total 
                                FROM cart c 
                                JOIN books b ON c.`Book ID` = b.ID 
                                WHERE c.`User ID` = $userId");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    
    function updateCart($cartId, $userId, $qty, $conn){
        return $conn->query("UPDATE cart SET Quantity = $qty 
                            WHERE ID = $cartId AND `User ID` = $userId");
    }
    
    function removeFromCart($cartId, $userId, $conn){
        return $conn->query("DELETE FROM cart 
                            WHERE ID = $cartId AND `User ID` = $userId");
    }
}
?>