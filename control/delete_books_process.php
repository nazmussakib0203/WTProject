<?php
include_once '../config/db.php';
include_once '../model/bookmodel.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $mydb = new MyDB();
    $conn = $mydb->createConn();
    deleteBooks($id, $conn);
    header("Location: ../view/listed_books.php");
}
?>