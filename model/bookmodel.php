<?php
function getBooks($conn) {
    $sql = "SELECT books.*, categories.Name as CategoryName 
            FROM books 
            JOIN categories ON books.CategoryID = categories.ID";
    return $conn->query($sql);
}
function createBooks($title, $author, $description, $price, $category, $image, $stock,$conn) {
    $sql = "INSERT INTO books (Title, Author, Description, Price, CategoryID, Image, Stock) VALUES ('$title', '$author', '$description', '$price', '$category', '$image', '$stock')";
    return $conn->query($sql);
}

function getBooksById($id, $conn) {
    $sql = "SELECT * FROM books WHERE ID = '$id'";
    return $conn->query($sql);
}

function updateBooks($id, $title, $author, $description, $price, $category, $image, $stock, $conn) {
    $sql = "UPDATE books SET Title='$title', Author='$author', Description='$description', Price='$price', CategoryID='$category', Image='$image', Stock='$stock' WHERE ID='$id'";
    return $conn->query($sql);
}
function deleteBooks($id, $conn) {
    $sql = "DELETE FROM books WHERE ID='$id'";
    return $conn->query($sql);
}
function getCategories($conn){
    $sql = "SELECT * FROM categories";
    return $conn->query($sql);
}

?>