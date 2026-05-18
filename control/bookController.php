<?php
require_once "../models/bookModel.php";
require_once "../config/db.php";

$book = new BookModel();

$id = $_GET['id'];

$data = $book->getById($conn, $id);

include "../views/bookDetails.php";