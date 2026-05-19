<?php
include_once '../config/db.php';
include_once '../model/bookmodel.php';

$mydb = new MyDB();
$conn =$mydb -> createConn();
$categories = getCategories($conn); 

$titleError = "";
$authorError = "";
$descriptionError = "";
$priceError = "";
$categoryError = "";
$imageError = "";
$stockError = "";

$title = "";
$author = "";
$description = "";
$price = "";
$categoryID = "";
$image = "";
$stock = "";
$id = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = getBooksById($id, $conn);

    foreach($result as $book){
        $title = $book['Title'];
        $author = $book['Author'];
        $description = $book['Description'];
        $price = $book['Price'];
        $categoryID = $book['CategoryID'];
        $image = $book['Image'];
        $stock = $book['Stock'];
    }
}

if(isset($_POST["Submit"])){
    $title = $_POST["title"];
    $author = $_POST["author"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $categoryID = $_POST["category"];
    $image = $_FILES["image"]["name"];
    $stock = $_POST["stock"];
    $hasError = false;
    
    if($title == ""){
        $titleError = "Title is required";
        $hasError = true;
    }
    if($author == ""){
        $authorError = "Author is required";
        $hasError = true;
    }
    if($description == ""){
        $descriptionError = "Description is required";
        $hasError = true;
    }
    if($price == ""){
        $priceError = "Price is required";
        $hasError = true;
    }
    if($price < 0){
        $priceError = "Price must be greater than 0";
        $hasError = true;
    }
    if($categoryID == ""){
        $categoryError = "Category is required";
        $hasError = true;
    }
    if($_FILES["image"]["name"] == ""){
        $imageError = "Image is required";
        $hasError = true;
    } else {
        $allowedTypes = ["image/jpeg", "image/png"];
        $maxSize = 2 * 1024 * 1024;

        if(!in_array($_FILES["image"]["type"], $allowedTypes)){
            $imageError = "Only JPEG or PNG allowed!";
            $hasError = true;
        }
        if($_FILES["image"]["size"] > $maxSize){
            $imageError = "Image must be 2MB or less!";
            $hasError = true;
        }
    }
    if($stock == ""){
        $stockError = "Stock is required";
        $hasError = true;
    }

    if($hasError == false){
        $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . "/BookStore/public/uploads/books/";
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFolder . $image);

        $mydb = new MyDB();
        $conn = $mydb->createConn();
        $result = updateBooks($id, $title, $author, $description, $price, $categoryID, $image, $stock, $conn);

        if($result){
            echo "DB update successful!";
            header("Location: listed_books.php");
        } else {
            echo "DB update failed!";
        }
    }
}
?>