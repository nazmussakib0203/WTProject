<?php
session_start();
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];

$cart = $conn->query("
    SELECT cart.*, books.title, books.price
    FROM cart
    JOIN books ON cart.book_id = books.id
    WHERE user_id=$user_id
");

include "../views/cart.php";