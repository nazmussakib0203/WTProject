<?php
session_start();
require_once "../models/bookModel.php";
require_once "../models/cartModel.php";
require_once "../config/db.php";

$book = new BookModel();
$cart = new CartModel();

$action = $_GET['action'] ?? "";

/* SEARCH */
if ($action == "search") {

    $q = $_GET['q'];
    $filter = $_GET['filter'];

    $data = $book->search($conn, $q, $filter);

    $result = [];

    while ($row = $data->fetch_assoc()) {
        $result[] = $row;
    }

    echo json_encode($result);
}


/* ADD TO CART */
if ($action == "add") {

    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $qty = $_POST['qty'];

    $cart->add($conn, $user_id, $book_id, $qty);

    echo json_encode(["msg" => "Added"]);
}


/* REMOVE */
if ($action == "remove") {

    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    $cart->remove($conn, $user_id, $book_id);

    echo json_encode(["msg" => "Removed"]);
}


/* UPDATE */
if ($action == "update") {

    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];
    $qty = $_POST['qty'];

    $cart->update($conn, $user_id, $book_id, $qty);

    echo json_encode(["msg" => "Updated"]);
}