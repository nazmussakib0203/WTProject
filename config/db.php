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

session_start();
if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'Guest';
}
?>