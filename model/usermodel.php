<?php
function getCustomerList($role, $conn) {
    $sql = "SELECT * FROM users WHERE Role='$role'";
    return $conn->query($sql);
}
function deleteCustomer($customer_id, $conn) {
    $sql = "DELETE FROM users WHERE ID='$customer_id'";
    return $conn->query($sql);
}

function getUserList($conn) {
    $sql = "SELECT * FROM users";
    return $conn->query($sql);
}
?>