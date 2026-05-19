<?php
require_once '../config/db.php';

class MyDBFunctions extends MyDB {
    
    // Get all books
    function getAllBooks($conn){
        $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID = c.ID";
        return $conn->query($sql);
    }
    
    // Search books
    function searchBooks($keyword, $filter, $conn){
        if($filter == 'title'){
            $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID = c.ID WHERE b.Title LIKE '%$keyword%'";
        }elseif($filter == 'author'){
            $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID = c.ID WHERE b.Author LIKE '%$keyword%'";
        }else{
            $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID = c.ID WHERE c.Name LIKE '%$keyword%'";
        }
        return $conn->query($sql);
    }
    
    // Get single book
    function getBookById($id, $conn){
        $sql = "SELECT b.*, c.Name as cat_name FROM books b LEFT JOIN categories c ON b.CategoryID = c.ID WHERE b.ID = $id";
        return $conn->query($sql);
    }
    
    // Add to cart
    function addToCart($uid, $bid, $qty, $conn){
        $check = $conn->query("SELECT ID FROM cart WHERE UserID=$uid AND BookID=$bid");
        if($check->num_rows > 0){
            $row = $check->fetch_assoc();
            return $conn->query("UPDATE cart SET Quantity = Quantity + $qty WHERE ID = {$row['ID']}");
        }else{
            return $conn->query("INSERT INTO cart (UserID, BookID, Quantity) VALUES ($uid, $bid, $qty)");
        }
    }
    
    // Get cart items
    function getCartItems($uid, $conn){
        return $conn->query("SELECT c.ID as cart_id, c.Quantity, b.ID as book_id, b.Title, b.Price FROM cart c JOIN books b ON c.BookID = b.ID WHERE c.UserID = $uid");
    }
    
    // Get cart count
    function getCartCount($uid, $conn){
        $result = $conn->query("SELECT SUM(Quantity) as total FROM cart WHERE UserID = $uid");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    
    // Get cart total
    function getCartTotal($uid, $conn){
        $result = $conn->query("SELECT SUM(b.Price * c.Quantity) as total FROM cart c JOIN books b ON c.BookID = b.ID WHERE c.UserID = $uid");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    
    // Update cart quantity
    function updateCart($cartId, $uid, $qty, $conn){
        return $conn->query("UPDATE cart SET Quantity = $qty WHERE ID = $cartId AND UserID = $uid");
    }
    
    // Remove from cart
    function removeFromCart($cartId, $uid, $conn){
        return $conn->query("DELETE FROM cart WHERE ID = $cartId AND UserID = $uid");
    }
}
?>