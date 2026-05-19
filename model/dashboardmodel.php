<?php
function getTotalBooks($conn){
    $sql = "SELECT COUNT(*) as total FROM books";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
function getTotalCustomers($conn){
    $sql = "SELECT COUNT(*) as total FROM users WHERE Role='customer'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
function getTotalOrders($conn){
    $sql = "SELECT COUNT(*) as total FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
function getTotalRevenue($conn){
    $sql = "SELECT SUM(TotalAmount) as total FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>