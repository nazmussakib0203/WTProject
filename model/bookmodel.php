<?php
function getBooks($conn) {
    $sql = "select * from books";
    return $conn->query($sql);
}
function createBooks($title, $author, $description, $price, $category, $image, $stock,$conn) {
    $sql = "INSERT INTO books (Title, Author, Description, Price, Category, Image, Stock) VALUES ('$title', '$author', '$description', '$price', '$category', '$image', '$stock')";
    return $conn->query($sql);
}
?>