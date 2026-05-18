<?php
class MyDB {

    function createConn() {
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

    function closeConn($conn) {
        $conn->close();
    }
}
?>
