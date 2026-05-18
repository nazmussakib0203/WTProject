<?php

class CartModel {

    function add($conn, $user_id, $book_id, $qty) {

        $check = $conn->query("SELECT * FROM cart WHERE user_id=$user_id AND book_id=$book_id");

        if ($check->num_rows > 0) {
            $conn->query("UPDATE cart SET quantity = quantity + $qty WHERE user_id=$user_id AND book_id=$book_id");
        } else {
            $conn->query("INSERT INTO cart(user_id, book_id, quantity) VALUES($user_id, $book_id, $qty)");
        }

        return true;
    }

    function remove($conn, $user_id, $book_id) {
        $conn->query("DELETE FROM cart WHERE user_id=$user_id AND book_id=$book_id");
    }

    function update($conn, $user_id, $book_id, $qty) {
        $conn->query("UPDATE cart SET quantity=$qty WHERE user_id=$user_id AND book_id=$book_id");
    }
}