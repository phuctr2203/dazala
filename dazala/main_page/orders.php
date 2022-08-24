<?php

require_once '../login_page/db.php';

session_start();

$prod_id = $_GET['prod_id'];
$cus_id = $_SESSION['cus_id'];

echo "<h1>Thank you for ordering</h1>";

$sql_get_product = "SELECT * FROM product WHERE id = '$prod_id'"; 
$stmt = $customer->query($sql_get_product);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
$bill = $product['price'];

$sql_find_near_hub = "CALL cal_nearest_distance('$prod_id');";
$stmt_find = $customer->query($sql_find_near_hub);
$near_hub = $stmt_find->fetch(PDO::FETCH_ASSOC);
$hub_id = $near_hub['id'];
$stmt_find->closeCursor();

$sql_orders = "CALL cus_buy_product($bill, '$hub_id', '$cus_id', '$prod_id');";
$stmt_orders = $customer->query($sql_orders);

?>

<button onclick='window.location.href="homepage.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button> 
<a href="customer_order.php">Check current orders</a><br><br>