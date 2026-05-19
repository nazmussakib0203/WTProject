<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bookstore_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}
?>