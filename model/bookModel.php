<?php

class BookModel {

    function search($conn, $q, $filter) {

        $sql = "SELECT * FROM books WHERE 1=1";

        if ($filter == "author") {
            $sql .= " AND author LIKE '%$q%'";
        } elseif ($filter == "title") {
            $sql .= " AND title LIKE '%$q%'";
        }

        return $conn->query($sql);
    }

    function getById($conn, $id) {
        return $conn->query("SELECT * FROM books WHERE id=$id")->fetch_assoc();
    }
}