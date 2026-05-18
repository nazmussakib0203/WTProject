<?php
class MyDB {

    function createConn(){
        $DBHOST = "localhost";
        $DBUSER = "root";
        $DBPASS = "";
        $DBNAME = "bookstore";
        
        $conn = new mysqli($DBHOST, $DBUSER, $DBPASS, $DBNAME);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        return $conn;
    }

    function closeConn($conn){
        $conn->close();
    }
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}
?>