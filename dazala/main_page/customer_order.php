<?php

require_once '../login_page/db.php';

session_start();

$cus_id = $_SESSION['cus_id'];

$sql_show_orders = "SELECT * FROM orders WHERE orders_status = 'Ready' AND cus_id = '$cus_id';";
$rows = $customer->query($sql_show_orders);

echo "<h1>Current Order</h1>";

foreach($rows as $row) {
    $id = $row['id'];
    $status = $row['orders_status'];
    $bill = $row['bill'];
    $quantity = $row['quantity'];
    $cus_id = $row['cus_id'];
    $hub_id = $row['hub_id'];
    $prod_id = $row['prod_id'];

    $sql_get_cus_name = "SELECT name FROM customer WHERE id = '$cus_id';";
    $stmt_cus_name = $customer->query($sql_get_cus_name);
    $row_cus_name = $stmt_cus_name->fetch(PDO::FETCH_ASSOC);
    $cus_name = $row_cus_name['name'];

    $sql_get_cus_address = "SELECT * FROM customer WHERE id = '$cus_id';";
    $stmt_cus_address = $customer->query($sql_get_cus_address);
    $row_cus_address = $stmt_cus_address->fetch(PDO::FETCH_ASSOC);
    $cus_address = $row_cus_address['address'];

    $sql_get_hub_name = "SELECT * FROM hub WHERE id = '$hub_id';";
    $stmt_hub_name = $shipper->query($sql_get_hub_name);
    $row_hub_name = $stmt_hub_name->fetch(PDO::FETCH_ASSOC);
    $hub_name = $row_hub_name['name'];

    echo "<br>ID: " . $id. "<br>Status: " . $status. "<br>Bill: $" . $bill. "<br>Quantity: " . $quantity. "<br>Customer name: " . $cus_name. "<br>Address: " . $cus_address. "<br>Hub Name: " . $hub_name . "<br>Product ID: " . $prod_id . "<br>";
    echo "<br>";
         
}

?>

<button onclick='window.location.href="homepage.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button> 