<?php
include_once("../config/db.php");
include_once("../model/usermodel.php");

if(isset($_GET['customer_id'])){
    $customer_id = $_GET['customer_id'];
    $mydb = new MyDB();
    $conn = $mydb->createConn();
    $result = deleteCustomer($customer_id, $conn);

    if($result === TRUE){
        header("Location: ../view/customer_list.php");
        exit();
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
}
?>