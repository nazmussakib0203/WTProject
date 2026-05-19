<?php
include_once("../config/db.php");
include_once("../model/dashboardmodel.php");

$mydb = new MyDB();
$conn = $mydb->createConn();
$totalBooks = getTotalBooks($conn);
$totalCustomers = getTotalCustomers($conn);
$totalOrders = getTotalOrders($conn);
$totalRevenue = getTotalRevenue($conn);

?>