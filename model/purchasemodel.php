<?php
function getPurchaseHistory($conn){
    $sql = "SELECT 
                users.Name,
                books.Title,
                orders.TotalAmount,
                orders.Status,
                orders.PaymentMethod,
                orders.OrderDate
            FROM users
            JOIN orders 
                ON users.ID = orders.UserID
            JOIN order_items 
                ON orders.ID = order_items.OrderID
            JOIN books 
                ON order_items.BookID = books.ID";
    return $conn->query($sql);
}
?>